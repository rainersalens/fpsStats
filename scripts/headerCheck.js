const loginButton = document.getElementById("loginButton");
const registerButton = document.getElementById("registerButton");
const logoutButton = document.getElementById("logoutButton");
const editButton = document.getElementById("editButton");
const loginCookie = getCookie('userName');

if (loginCookie.length > 0) {
  loginButton.style.display = "none";
  registerButton.style.display = "none";
  logoutButton.style.display = "initial";
  editButton.style.display = "initial";
} else if (loginCookie == 0) {
  loginButton.style.display = "initial";
  registerButton.style.display = "initial";
  logoutButton.style.display = "none";
  editButton.style.display = "none";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}