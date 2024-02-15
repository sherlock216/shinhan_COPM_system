<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true); //수신 decode
$user_key = $data['userRequest']['user']['properties']['plusfriendUserKey'];

$response = [
    "version" => "2.0",
    "template" => [
        "outputs" => [
            [
                "textCard" => [
                    "title" => "검사를 진행해볼까요?",
                    "description" => "***주의*** 검사 진행하기 버튼을 누른 페이지에서 검사 및 결과 조회를 진행해주세요! 링크를 복사하여 타 브라우저로 이동 시 저장 및 결과 조회가 되지 않습니다.",
                    "buttons" => [
                        [
                            "action" => "webLink",
                            "label" => "검사 진행하기",
                            "webLinkUrl" => "https://developnehub.cafe24.com/?user_key=" . $user_key
                        ]
                    ]
                ]
            ]
        ]
    ]
                        ];

echo json_encode($response); // encode
?>
