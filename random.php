<?php
header("Content-Type: application/json"); // JSON 응답 형식 설정

$data = json_decode(file_get_contents("php://input"), true); //수신 decode
$user_key = $data['userRequest']['user']['properties']['plusfriendUserKey'];

$response = [
    "version" => "2.0",
    "template" => [
        "outputs" => [
            [
                "textCard" => [
                    "title" => "검사를 진행해볼까요?",
                    "description" => "검사를 통해 운동 MBTI를 알아보세요.",
                    "buttons" => [
                        [
                            "action" => "webLink",
                            "label" => "소개 보러가기",
                            "webLinkUrl" => "https://developnehub.cafe24.com/" . $user_key
                        ]
                    ]
                ]
            ]
        ]
    ]
                        ];

echo json_encode($response); // JSON 형식으로 반환 encode
?>
