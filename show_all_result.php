<?php
session_start();

if(!isset($_SESSION['user_login'])){
    header('Location: login.html');
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>신한대학교 COPM System</title>
    <link rel="icon" type="image/jpg" href="image/favicon.jpg">
    <link rel="stylesheet" href="/css/show_result.css">
    <link rel="stylesheet" href="/css/button.css">

</head>

<body>
    <br><br>
    <table border="2" bordercolor="black" id="resultTable">
        <tr>
            <th>닉네임</th>
            <th>회차</th>
            <th>이동</th>
            <th>삭제</th>
        </tr>


    </table>


    <script>
        //이동버튼 함수
        function moveResult(move_key) {
            if (move_key) {
                fetch(`show_result.php?user_key=${encodeURIComponent(move_key)}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/text'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        sessionStorage.setItem('user_key', JSON.stringify(move_key));
                        sessionStorage.setItem('edition', data["edition"]);
                        sessionStorage.setItem('part0', data["part0"]);
                        sessionStorage.setItem('part1', data["part1"]);
                        sessionStorage.setItem('part2', data["part2"]);
                        sessionStorage.setItem('part3', data["part3"]);
                        sessionStorage.setItem('part4', data["part4"]);
                        sessionStorage.setItem('score', data["score"]);
                        sessionStorage.setItem('result', data["result"]);
                        location.href = "show_result.html";
                    })
                    .catch(error => alert('테스트를 한 기록이 없습니다. 시작하기를 눌러 테스트를 먼저 진행해주세요.'));
            } else {
                alert('카카오톡 채널을 통해 웹사이트에 접속해주세요.');
            }

        }
    </script>

    <script>
        //삭제버튼 함수
        function delok(delete_key) {
            if (confirm('정말 삭제하시겠습니까?')) {
                let formdata = new FormData();
                formdata.append('delete_key', JSON.stringify(delete_key));
                fetch(`delete.php`, {
                    method: 'POST',
                    body: formdata
                })
                    .then(response => response.text())
                    .then(data => {
                        alert('데이터 삭제에 성공했습니다.');
                        sessionStorage.clear();
                        location.href = "show_all_result.php";
                    })
                    .catch(error => alert('데이터 삭제에 실패했습니다.'));
            }
        }
    </script>

    <script>
        function loadData() {
            // Session Storage에서 데이터 가져오기
            for (let j = 0; j < sessionStorage.length; j++) {
                let key = sessionStorage.key(j);
                let item = sessionStorage.getItem(key);
                item = JSON.parse(item);

                const table = document.getElementById('resultTable');
                const new_row = table.insertRow();

                for (let i = 0; i <= 3; i++) {
                    const new_cell = new_row.insertCell(i);
                    let temp_html = ``;
                    if (i === 0) {
                        let temp_html = `<td>${item["part0"]["nickname"]}</td>`;
                        new_cell.insertAdjacentHTML('afterbegin', temp_html);
                    }
                    else if (i === 1) {
                        let temp_html = `<td>${item["edition"]}</td>`;
                        new_cell.insertAdjacentHTML('afterbegin', temp_html);
                    }
                    else if (i === 2) {
                        let temp_html = `<td><button onclick="moveResult('${item["user_key"]}')">이동</button></td>`;
                        new_cell.insertAdjacentHTML('afterbegin', temp_html);
                    }
                    else {
                        let temp_html = `<td><button onclick="delok('${item["user_key"]}')">삭제</button><td>`;
                        new_cell.insertAdjacentHTML('afterbegin', temp_html);
                    };
                }
            }
            //sessionStorage.clear();
        }


    </script>

    <script>
        let globaldata =[];
        // show_all로 모든것을 불러오기
        fetch("show_all.php", {
            method: 'GET'
        })
            .then(response => response.json())
            .then(data => {
                sessionStorage.clear();
                //foreach를 사용하여 각 데이터 세션 스토리지에 저장
                data.forEach((item) => {
                    sessionStorage.setItem(item["part0"]["nickname"], JSON.stringify(item));
                    globaldata.push(item);
                })
            })
            .then(loadData)
            .catch(error =>
                alert('테스트를 한 기록이 없습니다. 시작하기를 눌러 테스트를 먼저 진행해주세요.'
                ))
    </script>
    <br><br>




    <button type="button" onclick="downloadUsers(globaldata)">csv로 저장</button>

    <button type="button" onclick="location.href='logout.php';">로그아웃</button>

    <button type="button" onclick="location.href='edition.php';">회차 변경하기</button>

    <script>
        async function groupUsersToCSV(groupUsers) {
            if (groupUsers) { // result의 헤더가 되는 첫 번째 값
                let results = [['index', 'user_key', '회차', '닉네임', '청/중/장년층', 
                '생년 월일', '성별', '신장(cm)', '체중(kg)', '전화번호', 
                'BMI', '허리둘레(cm)', '인바디: 체지방(%)', '인바디: 근육량(%)', 
                '1-1', '1-2', '1-3', '1-4', '1-5', '2-1', '2-2', '2-3', '2-4', '2-5', 
                '2-6', '3-1', '3-2', '3-3', '맞춤형 운동 추천', '4-1', '4-2', '4-3', '4-4', 
                '4-5', '4-5-1', '4-5-2', '4-6', '4-7', '4-8', 'result1', 'result2', 'result3', 
                'result4', 'nowtime']]

                for (const gu of groupUsers) { //groupUsers: 파싱된 결과 배열
                    const user = gu.user_key
                    if (!user) continue

                    part0=gu["part0"];
                    part1=gu["part1"];
                    const part1_3 = `"${part1[3].join(', ')}"`; //배열을 문자열로 변환, 그것을 큰따옴표로 두르기
                    const part1_4 = `"${part1[4].join(', ')}"`;
                    const part1_5 = `"${part1[5].join(', ')}"`;
                    part2=gu["part2"];
                    const part2_1 = `"${part2[1].join(', ')}"`;
                    const part2_2 = `"${part2[2].join(', ')}"`;
                    const part2_3 = `"${part2[3].join(', ')}"`;
                    part3=gu["part3"];
                    const part3_2 = `"${part3[2].join(', ')}"`;
                    const part3_3 = `"${part3[3].join(', ')}"`;
                    part4=gu["part4"];
                    const part4_1 = `"${part4[1].join(', ')}"`;
                    const part4_6 = `"${part4[6].join(', ')}"`;
                    const part4_7 = `"${part4[7].join(', ')}"`;
                    score=gu["score"];
                    const score_exercise = `"${score[3]["운동"].join(', ')}"`;
                    result=gu["result"];

                    results.push([gu.idx, gu.user_key, gu.edition, part0["nickname"], part0["청/중/장년층"], 
                    part0["생년 월일"], part0["성별"], part0["신장"], part0["체중"], part0["전화번호"], 
                    part0["BMI_RARE"], (part0["허리둘레"] || 0), (part0["인바디: 체지방"] || 0), (part0["인바디: 근육량"] || 0), 
                    part1[1], part1[2], part1_3, part1_4, part1_5, part2_1, part2_2, part2_3, part2[4],
                    part2[5], part2[6], part3[1], part3_2, part3_3, score_exercise, part4_1, part4[2],
                    part4[3], part4[4], part4[5], (part4[51] || ' '), (part4[52]['술종류'] || '') + ' ' + (part4[52]['양'] || ''), part4_6, part4_7, part4[8], 
                    result[1], result[2], result[3], result[4], gu.nowtime].join(','))
                    // result.push([user.id, user.email, user.full_name, `'` + (user.profile.phone || '-'), `'` + (user.profile.phone_alt || '-')].join(','))
                }
                return results.join('\n')
            }
        }

        async function downloadUsers(group) {
            if (!group) {
                alert("데이터가 없습니다!");
                return false;
            }
            if (!confirm('전체 사용자를 다운로드하시겠습니까?\n사용자가 많을 경우 오랜 시간이 소요될 수 있습니다.')) return false
            let texts = await this.groupUsersToCSV(group)
            let file = new Blob([texts], { type: 'text/plain' })
            let filename = `${group.name}.csv`
            this._downloadFile(file, filename)
            alert("성공");
        }

        function _downloadFile(file, filename) {
            let eleA = document.createElement('a')
            eleA.setAttribute('download', filename)
            if (window.webkitURL != null) {
                eleA.href = window.webkitURL.createObjectURL(file)
            } else {
                eleA.href = window.URL.createObjectURL(file)
                eleA.style.display = 'none'
                document.body.appendChild(eleA)
            }
            eleA.style.display = 'none'
            document.body.appendChild(eleA)
            eleA.click()
            document.body.removeChild(eleA)
        }

    </script>




</body>

</html>