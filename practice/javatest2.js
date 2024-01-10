// closure
function makeCounter(){
    let num=0;

    return function(){
        return num++;
    };
}

let counter=makeCounter();

console.log(counter());
console.log(counter());
console.log(counter());

//setTimeout, setInterval
function showName(name){
    console.log(name);
}
setTimeout(showName, 3000, 'Mike');

let num=0;
function showTime(){
    console.log(`안녕하세요, 접속하신지 ${num++}초가 지났습니다.`);
    if(num>5){
        clearInterval(tId);
    }
}

const tId = setInterval(showTime, 1000);