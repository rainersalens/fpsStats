
function checkregister(){

    var passwordreg = document.getElementById("passreg").value;
    var passwordtworeg = document.getElementById("passtworeg").value;
    var emailreg = document.getElementById("emailreg").value;
    var usernreg = document.getElementById("usernreg").value;
    
    if(passwordreg == "" || passwordtworeg == "" || emailreg == "" || usernreg == "") {
        window.alert("One or more of the input fields are left empty!")
    } else if(passwordreg != passwordtworeg) {
        window.alert("The passwords are not the same. Try re-entering them.")
    } else if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailreg.value)) {
    }

}

function checklogin(){
    var usernlog = document.getElementById("usernlog").value;
    var passlog = document.getElementById("passlog").value;

    if(usernlog == "" || passlog == ""){
        window.alert("One of the 2 input fields is empty!")
    }
}