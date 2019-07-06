const canvas=document.querySelector("canvas");
const butClear=document.querySelector("button#clear");
const butSend=document.querySelector("button#send");

const ctx=canvas.getContext("2d");
const canvasCoords={x:canvas.getBoundingClientRect().left,y:canvas.getBoundingClientRect().top};
let currentNum=0;
let coordsArr=[];

canvas.addEventListener("click",addVerticle);
butClear.addEventListener("click",clearCanvas);
butSend.addEventListener("click",send);

function addVerticle(event){
    const x=event.clientX-canvasCoords.x;
    const y=event.clientY-canvasCoords.y;
    ctx.beginPath();
    ctx.arc(x,y,10,0,2*Math.PI);
    ctx.fillText(currentNum,x-3,y+3);
    ctx.stroke();
    currentNum++;
    coordsArr.push({"x":x,"y":y});
}

function clearCanvas(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    currentNum=0;
    coordsArr=[];
}

function send(){
    let data=JSON.stringify(coordsArr);
    let xhr = new XMLHttpRequest();
    xhr.open("GET","main.php?data="+data, true);
    xhr.onreadystatechange=function(){
        if (xhr.readyState != 4) return    
        if (xhr.status == 200) {
            alert(xhr.responseText);
            let matrix=JSON.parse(xhr.responseText)
            writeResponseTable(matrix);
            drawEdges(matrix);
        }    
    }
    xhr.send();
}

function writeResponseTable(matrix){
    let table="<table border='1px'><tr style='color:red'><td></td>";
    for(let i=0;i<matrix.length;i++){
        table+="<td>"+i+"</td>";
    }
    table+="<tr>";
    for(let i=0;i<matrix.length;i++){
        table+="<tr><td style='color:red'>"+i+"</td>";
        for(let j=0;j<matrix[i].length;j++){
            table+="<td>"+matrix[i][j]+"</td>";
        }
        table+="</tr>";
    }
    document.querySelector("#table").innerHTML=table;
}

function drawEdges(matrix){
    for(let i=0;i<matrix.length;i++){
        for(let j=0;j<matrix[i].length;j++){
            if(matrix[i][j]==1){
                ctx.moveTo(coordsArr[i].x,coordsArr[i].y);
                ctx.lineTo(coordsArr[j].x,coordsArr[j].y); 
            }
        }
    }
    ctx.stroke();
}