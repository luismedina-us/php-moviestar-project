<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/Movie.php");
    require_once("models/Review.php");
    require_once("models/Message.php");
    require_once("dao/userDAO.php");
    require_once("dao/movieDAO.php");
    require_once("dao/ReviewDAO.php");

    $message = new Message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);
    $movieDAO = new MovieDAO($conn, $BASE_URL);
    $reviewDAO = new ReviewDAO($conn, $BASE_URL);

    // Receive form type
    $type = filter_input(INPUT_POST, "type");

    // Rescue user data
    $userData = $userDAO->verifyToken();

    if($type === "create") {

        // Recive post data
        $rating = filter_input(INPUT_POST, "rating");
        $review = filter_input(INPUT_POST, "review");
        $movies_id = filter_input(INPUT_POST, "movies_id");
        $users_id = $userData->id;

        $reviewObject = new Review();
        
        $movieData = $movieDAO->findById($movies_id);

        // Verify if found movie
        if($movieData) {

            // Data verification 
            if(!empty($rating) && !empty($review) && !empty($movies_id)){

                $reviewObject->rating = $rating;
                $reviewObject->review = $review;
                $reviewObject->movies_id = $movies_id;
                $reviewObject->users_id = $users_id;

                $reviewDAO->create($reviewObject);

            } else {

                $message->setMessage("Please fill rating and review!", "error", "back");

            }

        } else {

            $message->setMessage("Invalid data provided!", "error", "index.php");

        }

    } else {

        $message->setMessage("Invalid data provided!", "error", "index.php");

    }