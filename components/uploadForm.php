<article class="message is-large is-success" style="display:none" id="message">
  <div class="message-header">
    <p>Готово</p>
  </div>
  <div class="message-body">
    <p>Файл: <span id="filename" class="has-text-info"></span></p><br>
    <span>ссылка на скачивание: </span><span id="downloadLink" class="has-text-info"></span><div class="button" id="butCopy">Скопировать</div>
  </div>
</article>


<form>
<div class="file has-name is-boxed is-centered is-primary">
  <label class="file-label">
    <input class="file-input" type="file" name="resume"  id="fileInput">
    <span class="file-cta">
      <span class="file-icon">
        <i class="fas fa-upload"></i>
      </span>
      <span class="file-label">
        Выберите файл
      </span>
    </span>
    <span class="file-name is-hidden id-centered" id="fileName">
    </span>
  </label>
</div>

<br>
<div class="field">
  <input class="input" type="password" placeholder="Пароль(необязательно)" style="width:300px" id="password">
</div>

<br>
<div class="button is-link" id="sendBut">отправить</div>
</form>


<script>
    const fileInput=document.getElementById("fileInput");
    const sendBut=document.getElementById("sendBut");

    sendBut.addEventListener("click",()=>{
      let fileData=new FormData();
      const xhr=new XMLHttpRequest();
      fileData.append("file",fileInput.files[0]);
      $passwordVal=document.getElementById("password").value;
      if($passwordVal!=""){
        fileData.append("password",document.getElementById("password").value);
      }
      xhr.open('POST', 'php/doUpload.php', true);
      xhr.send(fileData);      
      sendBut.className="button is-link is-loading";
      xhr.onreadystatechange = function() {
        if (xhr.readyState != 4) return;
        sendBut.className="button is-link";
        if (xhr.status == 200) {
          console.log(xhr.responseText);
          showMessageReady(JSON.parse(xhr.responseText));         
        } 
      }
    })

    fileInput.addEventListener("change",()=>{
        if(fileInput.files.length>0){
            const fileNameSpan=document.getElementById("fileName")
            fileNameSpan.innerHTML=fileInput.files[0].name;
            fileNameSpan.className="file-name";
        }
    });

    function showMessageReady(data){
      let name=data.name;
      let fullLink=data.link;
      let link=data.link;
      if(link.length>10){
        link=link.substring(0,9)+"...";
      }
      document.getElementById("message").style.display="block";
      document.getElementById("filename").innerHTML=name;
      document.getElementById("downloadLink").innerHTML=link;
      document.getElementById("butCopy").onclick=()=>{
        navigator.clipboard.writeText(fullLink)
          .then(() => {
            alert("скопировано в буфер обмена");
          })
      }
    }
</script>