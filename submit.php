<?php

$uploadDir = 'uploads/';
$allowTypes = array('jpg','png','jpeg');

$response = array(
    'status' => 0,
    'message'=> 'Form submission failed, please try again.'

);

$errMsg = ''; 
$valid = 1; 
if(isset($_POST['Museum_id']) || isset($_POST['image_url'])){ 
    // Get the submitted form data 
    $id = $_POST['Museum_id']; 
    $filesArr = $_FILES["image_url"];
    // Check whether submitted data is not empty 
    if($valid == 1){ 
        $uploadStatus = 1; 
        $fileNames = array_filter($filesArr['name']); 
         
        // Upload file 
        $uploadedFile = ''; 
        if(!empty($fileNames)){  
            foreach($filesArr['name'] as $key=>$val){  
                // File upload path  
                $fileName = basename($filesArr['name'][$key]);  
                $targetFilePath = $uploadDir . $fileName;  
                  
                // Check whether file type is valid  
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);  
                if(in_array($fileType, $allowTypes)){  
                    // Upload file to server  
                    if(move_uploaded_file($filesArr["tmp_name"][$key], $targetFilePath)){  
                        $uploadedFile .= $fileName.','; 
                    }else{  
                        $uploadStatus = 0; 
                        $response['message'] = 'Sorry, there was an error uploading your file.'; 
                    }  
                }else{  
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed to upload.'; 
                }  
            }  
        } 
         
        if($uploadStatus == 1){ 
            // Include the database config file 
            include_once 'connect_db.php'; 
             
            // Insert form data in the database 
            $uploadedFileStr = trim($uploadedFile, ','); 
            $insert = $pdo->query("INSERT INTO museum_images (Museum_id,image_url) VALUES ('".$id."', '".$uploadedFileStr."')"); 
             
            if($insert){ 
                $response['status'] = 1; 
                $response['message'] = 'Form data submitted successfully!'; 
            } 
        } 
    }else{ 
         $response['message'] = 'Please fill all the mandatory fields!'.$errMsg; 
    } 
} 
 
// Return response 
echo json_encode($response);