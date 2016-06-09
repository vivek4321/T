<?php
 	require_once("Rest.inc.php");
	// it extends rest for giving rest error status
	class API extends REST {

		public $data = "";

		const DB_SERVER = "127.0.0.1";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "telugu";

		private $db = NULL;
		private $mysqli = NULL;
		public function __construct(){
			parent::__construct();
			$this->dbConnect();					// Database connection
		}

		/*
		 *  Connect to Database
		*/
		private function dbConnect(){
			$this->mysqli = new mysqli(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
		}

		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page not found".
		}


		//http://localhost/T/review
		private function review(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.reviewID, c.MovieName, c.MoviePoster, c.MovieCastNCrew, c.MoviePositives, c.MovieNegatives,
      c.MovieRating, c.MovieSingleLineReview, c.MovieReview, c.MovieDirector , c.MovieProducer, c.MovieMusic,
      c.MovieStory, c.MovieTech FROM reviews c order by c.reviewID desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}
		// this is for getting a particular profile of student use get
		//http://localhost/T/reviewByID?id=1
		private function reviewByID(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];

			if($id > 0){
				$query="SELECT distinct  c.MovieName, c.MoviePoster, c.MovieCastNCrew, c.MoviePositives, c.MovieNegatives,
        c.MovieRating, c.MovieSingleLineReview, c.MovieReview, c.MovieDirector , c.MovieProducer, c.MovieMusic,
        c.MovieStory, c.MovieTech FROM reviews c where c.reviewID=$id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//http://localhost/T/insertReview
		private function insertReview(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$review = json_decode(file_get_contents("php://input"),true);
			$column_names = array('MovieName', 'MoviePoster', 'MovieCastNCrew', 'MoviePositives', 'MovieNegatives', 'MovieRating',
       'MovieSingleLineReview', 'MovieReview', 'MovieDirector', 'MovieProducer', 'MovieMusic', 'MovieStory', 'MovieTech');
			$keys = array_keys($review);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the Review received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $review[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO reviews(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($review)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "review Created Successfully.", "data" => $review);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}



		//http://localhost/T/deletereview?id=101
		private function deletereview(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){
				$query="DELETE FROM reviews WHERE reviewID = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);

			}else
				$this->response('',204);	// If no records "No Content" status
		}



		//FOR REGISTRATION#############################################################################################################################

		//http://localhost/T/registered
		private function registered(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.userID, c.firstname, c.lastname, c.smail, c.mobile, c.password FROM registration c order by c.userID desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//http://localhost/T/registration
		private function registration(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$bearcat = json_decode(file_get_contents("php://input"),true);
			$column_names = array('firstname', 'lastname', 'smail', 'mobile', 'password');
			$keys = array_keys($bearcat);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the bearcat received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $bearcat[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO registration(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($bearcat)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "bearcat Created Successfully.", "data" => $bearcat);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}

		//for news


		//for getting all news
		//http://localhost/T/news
		private function news(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct  c.nID, c.nTitle, c.nImageName, c.nDescription FROM news c order by c.nID desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}
		// this is for getting a single news
		//http://localhost/T/newsByID?id=1
		private function newsByID(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];

			if($id > 0){
				$query="SELECT distinct  c.nID, c.nTitle, c.nImageName, c.nDescription FROM news c order by c.nID desc";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//for inserting news
		//http://localhost/T/insertN
		private function insertN(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$bearcat = json_decode(file_get_contents("php://input"),true);
			$column_names = array('nTitle', 'nImageName', 'nDescription');
			$keys = array_keys($bearcat);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the bearcat received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $bearcat[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO news(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($bearcat)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "news Created Successfully.", "data" => $bearcat);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status
		}



		//http://localhost/T/deleteNews?id=101
		private function deleteNews(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){
				$query="DELETE FROM news WHERE nID = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one news item."+$id );
				$this->response($this->json($success),200);

			}else
				$this->response('',204);	// If no records "No Content" status
		}

		//##### for trailers ##########

		//http://localhost/T/trailers
		private function trailers(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.trailerId, c.trailerTitle, c.trailerUrl, c.trailerMoviename FROM trailers c order by c.trailerId desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//http://localhost/T/trailerByID?id=1
		private function trailerByID(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];

			if($id > 0){
				$query="SELECT distinct  c.trailerId, c.trailerTitle, c.trailerUrl, c.trailerMoviename FROM trailers c where c.trailerId=$id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//Post trailer
		//http://localhost/T/insertTrailer
		private function insertTrailer(){
			if($this->get_request_method() != "POST"){
				$this.response('', 406);
			}

			$trailer = json_decode(file_get_contents("php://input"), true);
			$column_names = array('trailerMoviename', 'trailerUrl', 'trailerTitle');
			$keys = array_keys($trailer);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the trailer received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $trailer[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO trailers(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($trailer)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "news Created Successfully.", "data" => $trailer);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status

		}

		//http://localhost/T/deleteTrailer?id=101
		private function deleteTrailer(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){
				$query="DELETE FROM trailers WHERE trailerId = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);

			}else
				$this->response('',204);	// If no records "No Content" status
		}

		//##### end of trailers ##########
		//##### for images ##########


		//http://localhost/T/imagesas
		private function imagesas(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);

			}
			$query="SELECT distinct c.imageID, c.imageName, c.rootPath, c.galleryName FROM images c ";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//http://localhost/T/imageByID?id=1
		private function imageByID(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];

			if($id > 0){
				$query="SELECT distinct c.imageID, c.imageName, c.rootPath, c.galleryName  FROM images c where c.imageID = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
		//get by rootPath
		//http://localhost/T/imageByPath?root=1
		private function imageByPath(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$root = (int)$this->_request['root'];

			if(strlen($root) > 0){
				$query="SELECT distinct c.imageID, c.imageName, c.rootPath, c.galleryName  FROM images c where c.rootPath = $root ";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
		//get by galery name
		//http://localhost/T/imageByGN?GN=1
		private function imageByGN(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$galeryName = (int)$this->_request['GN'];

			if(strlen($galeryName) > 0){
				$query="SELECT distinct c.imageID, c.imageName, c.rootPath, c.galleryName  FROM images c where c.galleryName = $galeryName ";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}
		//http://localhost/T/insertImages
		private function insertImages(){
			if($this->get_request_method() != "POST"){
				$this.response('', 406);
			}

			$image = json_decode(file_get_contents("php://input"), true);
			$column_names = array('imageName', 'rootPath', 'galleryName');
			$keys = array_keys($image);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the image received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $image[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO images(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($image)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "image Created Successfully.", "data" => $image);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status

		}


		//http://localhost/T/deleteImages?id=101
		private function deleteImages(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){
				$query="DELETE FROM images WHERE imageID = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);

			}else
				$this->response('',204);	// If no records "No Content" status
		}



		//##### for upcomming Movies ##########

		//http://localhost/T/upInMovies
		private function upInMovies(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.movieId, c.movieName, c.ditectorProducer, c.cast, c.others , c.expReleaseDate, c.picRoute, c.details FROM upcommingmovies c order by c.movieId desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//http://localhost/T/movieByID?id=1
		private function movieByID(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];

			if($id > 0){
				$query="SELECT distinct c.movieId, c.movieName, c.ditectorProducer, c.cast, c.others , c.expReleaseDate, c.picRoute, c.details FROM upcommingmovies c where c.movieId=$id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//Post trailer
		//http://localhost/T/insertUpMovie
		private function insertUpMovie(){
			if($this->get_request_method() != "POST"){
				$this.response('', 406);
			}

			$upmovie = json_decode(file_get_contents("php://input"), true);
			$column_names = array('movieId', 'movieName', 'ditectorProducer', 'cast', 'others', 'expReleaseDate', 'picRoute','details');
			$keys = array_keys($upmovie);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the upmovie received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $upmovie[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO upcommingmovies(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($upmovie)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "upmovie Created Successfully.", "data" => $upmovie);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status

		}

		//http://localhost/T/deleteUpMovie?id=101
		private function deleteUpMovie(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){
				$query="DELETE FROM upcommingmovies WHERE movieId = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);

			}else
				$this->response('',204);	// If no records "No Content" status
		}

		//##### end of upcomming Movies ##########

		//##### for events ##########

		//http://localhost/T/event
		private function event(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$query="SELECT distinct c.eventId, c.eventName, c.eventDesc, c.picURL, c.eventDetails FROM event c order by c.eventId desc";
			$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);

			if($r->num_rows > 0){
				$result = array();
				while($row = $r->fetch_assoc()){
					$result[] = $row;
				}
				$this->response($this->json($result), 200); // send user details
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//http://localhost/T/eventByID?id=1
		private function eventByID(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];

			if($id > 0){
				$query="SELECT distinct c.eventId, c.eventName, c.eventDesc, c.picURL, c.eventDetails  FROM event c where c.eventId=$id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				if($r->num_rows > 0) {
					$result = $r->fetch_assoc();
					$this->response($this->json($result), 200); // send user details
				}
			}
			$this->response('',204);	// If no records "No Content" status
		}

		//Post trailer
		//http://localhost/T/insertEvent
		private function insertEvent(){
			if($this->get_request_method() != "POST"){
				$this.response('', 406);
			}

			$event = json_decode(file_get_contents("php://input"), true);
			$column_names = array('eventId', 'eventName', 'eventDesc', 'picURL', 'eventDetails');
			$keys = array_keys($event);
			$columns = '';
			$values = '';
			foreach($column_names as $desired_key){ // Check the event received. If blank insert blank into the array.
			   if(!in_array($desired_key, $keys)) {
			   		$$desired_key = '';
				}else{
					$$desired_key = $event[$desired_key];
				}
				$columns = $columns.$desired_key.',';
				$values = $values."'".$$desired_key."',";
			}
			$query = "INSERT INTO event(".trim($columns,',').") VALUES(".trim($values,',').")";
			if(!empty($event)){
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "event Created Successfully.", "data" => $event);
				$this->response($this->json($success),200);
			}else
				$this->response('',204);	//"No Content" status

		}

		//http://localhost/T/deleteEvent?id=101
		private function deleteEvent(){
			if($this->get_request_method() != "DELETE"){
				$this->response('',406);
			}
			$id = (int)$this->_request['id'];
			if($id > 0){
				$query="DELETE FROM event WHERE eventId = $id";
				$r = $this->mysqli->query($query) or die($this->mysqli->error.__LINE__);
				$success = array('status' => "Success", "msg" => "Successfully deleted one record.");
				$this->response($this->json($success),200);

			}else
				$this->response('',204);	// If no records "No Content" status
		}

		//##### end of trailers ##########





		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}

	// Initiiate Library

	$api = new API;
	$api->processApi();
?>
