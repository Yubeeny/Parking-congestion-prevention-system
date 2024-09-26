<?php
// 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "testDB";

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 데이터베이스로부터 데이터 가져오기
$sql = "SELECT id, file_path, capture_time FROM photo_table";
$result = $conn->query($sql);


// 가져온 데이터를 배열에 저장
$photos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // 절대 경로 생성

       // $relativePath =  $row["file_path"];

	//error_log("Image path from database: " . $relativePath);
        $webServerUrl = "http://localhost/";
        $photo = array(
           'id' => $row["id"],
           'file_path' => $webServerUrl . $row["file_path"],
           'capture_time' => strtotime($row["capture_time"])
    );

        $photos[] = $photo;

    }

} else {
    error_log("No records found in the database.");
}

// 데이터베이스 연결 종료
$conn->close();

//header('Content-Type: application/json');
//echo json_encode($photos);

//exit;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Records</title>
</head>
<body>


<?php
// 각각의 이미지와 시간을 HTML로 출력
foreach ($photos as $photo) {
    echo "<div>";
    echo "<img src='{$photo['file_path']}' alt='Photo {$photo['id']}' width='200' height='150' />";  
    echo "<p>Parked at: " . date('Y-m-d H:i:s', $photo['capture_time']) . "</p>";
    echo "</div>";
}
?>

</body>
</html>