/*const http = require('http');
const fs = require('fs');


http.createServer((req, res) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');

    //preflight request. CORS 상황 발생 해결법
    if(req.method === 'OPTIONS'){
        res.writeHead(200);
        res.end();
        return;
    }

    if (req.method === 'POST' && req.url === '/submit') {
        let body = '';

        req.on('data', chunk => {
            body += chunk.toString(); // 데이터 조각을 문자열로 변환
        });

        req.on('end', () => {
            const postData = JSON.parse(body); // JSON으로 파싱
            console.log(postData); // 일단 중간점검

            const nickname = postData[0].nickname || 'default';
            const filename = `${nickname}_data.json`;

            fs.writeFile(filename, JSON.stringify(postData, null, 2), err => {
                if (err) throw err;
                console.log('Data saved to file');
            });
            // 응답 보내기
            res.writeHead(200, {'Content-Type': 'application/json'});
            res.end(JSON.stringify({ message: 'Data received successfully' }));
        });
    } else {
    // 다른 경로에 대한 처리
    res.writeHead(404, {'Content-Type': 'text/plain'});
    res.end('404 Not Found');
}
})

.listen(8080, () => {
console.log('8080번 포트에서 서버 대기 중입니다!');
});*/

const express = require('express');
const fs = require('fs');
//CORS 상황 발생 해결법
const cors = require('cors');
const app = express();


app.use(cors());
app.use(express.json()); // JSON 요청 본문을 처리하기 위한 미들웨어

// CORS 미들웨어 설정(const cors 덕분에 필요없을듯)
/*app.use((req, res, next) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    next(); // 다음 미들웨어로 이동
});*/


// POST 요청 처리
app.post('/submit', (req, res) => {
    const postData = req.body; // Express의 body-parser가 요청 본문을 파싱
    console.log(postData);

    const nickname = postData[0].nickname || 'default';
    const filename = `${nickname}_data.json`;

    fs.writeFile(filename, JSON.stringify(postData, null, 2), err => {
        if (err) {
            res.status(500).send('서버 에러입니다!!!');
            throw err;
        }
        console.log('*****데이터 정상적으로 저장 완료*****');
        res.status(200).json({ message: 'Successfully Completed' });
    });
});

// 404 처리 미들웨어
app.use((req, res) => {
    res.status(404).send('404 Not Found');
});


// 서버 시작
app.listen(3000, () => {
    console.log('3000번 포트에서 서버 대기 중입니다!');
});
