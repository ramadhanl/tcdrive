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

		$query = $this->db->get('data_kp');
		foreach ($query->result() as $row)
		{
			//echo "<p>========================================</p>";
		    $id_doc = $row->id;
		    //echo "<p>".$id_doc."</p>";
		    $judul = $row->judul_kp;
		    $tokens = $tokenizer->tokenize($judul);
		    foreach ($tokens as $token) {
		    	//echo "<p>Before : ".$token."</p>";
		    	$token = $stemmer->stem($token);
		    	//echo "<p>After : ".$token."</p>";
		    	if(strlen($token)!==0){
		    		$query2=$this->db->get_where('terms', array('term' => $token));
		    		foreach ($query2->result() as $row2){
		    			$id_term=$row2->id_term;
		    		}
		    		$banyak=$query2->num_rows();
		    		if($banyak==0){
		    			//echo "<p>Term ".$token." belum ada lo</p>";
		    			$data = array('term' => $token);
		    			$this->db->insert('terms', $data);
		    			echo "<p>Insert ".$token." to terms table.</p>";
		    		}
		    		else{
		    			//echo "<p>Term ".$token." sudah ada</p>"; 
		    			$query3 = $this->db->get_where('tf', array('id_term' => $id_term,'id_doc'=>$id_doc));
						$banyak=$query3->num_rows();
						if($banyak==0){
		    				$data = array('id_term' => $id_term,'id_doc'=>$id_doc,'frequency' => 0);
		    				$this->db->insert('tf', $data); 
		    				echo "<p>Insert ".$id_term." and ".$id_doc." to tf table.</p>";
		    			}
		    			else{
		    				$query3 = $this->db->get_where('terms', array('id_term' => $id_term,'id_doc'=>$id_doc));
		    				foreach ($query3->result() as $row3){
								$frequency = $row3->frequency;
								$id = $row3->id;}
							$frequency=$frequency+1;
							$data = array('id_term' => $id_term,'id_doc'=>$id_doc);
							$this->db->where('id', $id);
							$this->db->update('tf', $data); 
		    			}
		    		}
		    	}
		    }
		}

	}
}