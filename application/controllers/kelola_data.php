<?php
class Kelola_data extends CI_Controller {
	public function index()
	{
		$this->load->view('home');
	}
	public function tokenizer()
	{
		require_once  __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$tokens = $tokenizer->tokenize('Saya membeli barang seharga Rp 5.000 di Jl. Prof. Soepomo no. 67.');
		var_dump($tokens);
		echo strtolower($tokens[0]);
	}
	public function stemmer(){
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		// create stemmer
		// cukup dijalankan sekali saja, biasanya didaftarkan di service container
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		
		// stem
		$sentence = 'Sumatera selatan Perekonomian Indonesia sedang dalam pertumbuhan yang membanggakan belajar bermain sepak bola';
		echo $sentence . "\n";
		$output   = $stemmer->stem($sentence);
		$tokens = $tokenizer->tokenize($output);
		var_dump($output);
		var_dump($tokens);
		echo $output . "\n";
		// ekonomi indonesia sedang dalam tumbuh yang bangga
		echo $stemmer->stem('Mereka meniru-nirukannya') . "\n";
		// mereka tiru
	}
	public function tfidf(){
		require_once __DIR__.'/sastrawi/vendor/autoload.php';
		$tokenizerFactory  = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();

		$query = $this->db->get_where('data_kp', array('status' => NULL));
		foreach ($query->result() as $row)
		{	
			$data = array('status' => 1);
			$this->db->where('id', $row->id);
			$this->db->update('data_kp', $data);

			$id_doc = $row->id;
		    $judul = $row->judul_kp;
		    $tokens = $tokenizer->tokenize($judul);
		    //Mencari term frequency
		    foreach ($tokens as $token) {
		    	$token = $stemmer->stem($token);
		    	if(strlen($token)!==0){
		    		$query2=$this->db->get_where('terms', array('term' => $token));
		    		$banyak=$query2->num_rows();
		    		if($banyak==0){
		    			$data = array('term' => $token);
		    			$this->db->insert('terms', $data);
		    			echo "<p>Insert ".$token." to terms table.</p>";
		    		}    
		    		else{
		    			$query2=$this->db->get_where('terms', array('term' => $token));
			    		foreach ($query2->result() as $row2){
			    			$id_term=$row2->id_term;
			    		}
		    			$query3 = $this->db->get_where('tf', array('id_term' => $id_term,'id_doc'=>$id_doc));
						$banyak=$query3->num_rows();
						if($banyak==0){
		    				$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'frequency' => 0);
		    				$this->db->insert('tf', $data);
		    				echo "<p>Insert ".$id_term." and ".$id_doc." to tf table.</p>";
		    			}
		    			else{
		    				$query4 = $this->db->get_where('tf', array('id_term' => $id_term,'id_doc'=>$id_doc));
		    				foreach ($query4->result() as $row4){
								$frequency = $row4->frequency;
								$id = $row4->id;}
							$frequency=$frequency+1;
							$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'frequency' => $frequency);
							$this->db->where('id', $id);
							$this->db->update('tf', $data); 
							echo "<p>Update frequency row with id =  ".$id." to tf table.</p>";
		    			}
		    		}
		    	}
		    }
		}
		$query=$this->db->get('terms');
	    foreach ($query->result() as $row){
			$id_term=$row->id_term;
			echo $id_term."-\n";
			$query2 = $this->db->get_where('tf', array('id_term' => $id_term));
			$df=$query2->num_rows();
			$n = $this->db->get('data_kp')->num_rows();
			$idf = log($n/$df);
			$data = array('df' => $df,'idf' => $idf);
			$this->db->where('id_term', $id_term);
			$this->db->update('terms', $data); 
		}
	}
}