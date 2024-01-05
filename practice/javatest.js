const user={
    name:"Mike",
    age:30,
};

const showName=Symbol("show name");
user[showName]=function(){
    console.log(this.name);
};

user[showName]();

for(let key in user){
    console.log(`His ${key} is ${user[key]}.`);
}

let num=10;
console.log(num.toString(16));

console.log(Math.floor(Math.random()*100)+1);

// 문자열 메서드(inclues)
function hasCola(str){
    if(str.includes('콜라')){
        console.log('금칙어가 있습니다.');
    } else{
        console.log('통과');
    }
}
hasCola("콜라와 사이다");

// 배열 메서드(splice)
let arr = ['나는', '철수', '입니다'];
arr.splice(1, 2, "대한민국", "소방관");
console.log(arr);

// 배열 메서드(forEach)
let arr2 = ['Mike', 'Tom', 'Jane'];
arr2.forEach((name, index) => {
    console.log(`${index+1}. ${name}`);
})

let userList=[
    {name: 'Mike', age:30},
    {name: 'Jane', age:27},
    {name: 'Tom', age:10},
];


let newUserList=userList.map((user, index)=> {
    return Object.assign({}, user, {
        id: index + 1,
        isAdult: user.age > 19,
    });
});

console.log(newUserList);
console.log(userList);

//Array.isArray()

let user2={
    name:"Mike",
    age:30,
};
let userList2=['Mike', 'Tom', 'Jane'];
console.log(typeof user2);
console.log(typeof userList2);
console.log(Array.isArray(user2));
console.log(Array.isArray(userList2));


//sort
let sort_arr=[27,8,5,13];

sort_arr.sort((a,b)=>{
    return a-b;
});

console.log(sort_arr);

//reduce
let arr3=[1,2,3,4,5];
const result3=arr3.reduce((prev, cur)=>{
    return prev+cur;
}, 100)
console.log(result3);

let userList4=[
    {name: "Mike", age:30},
    {name: "Tom", age:10},
    {name: "Jane", age:27},
    {name: "Sue", age:26},
    {name: "Harry", age:43},
    {name: "Steve", age:60},
]

let result4=userList4.reduce((prev, cur)=>{
    if(cur.name.length===3){
        prev.push(cur.name);
    }
    return prev;
}, []);
console.log(result4);


let a=1;
let b=2;
[a,b]=[b,a];