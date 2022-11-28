function getInput() {
    var userInputName = document.getElementById("usern").value;
    if (userInputName == "") { window.alert("No input found") }
    else {
        fetchData(userInputName);
    }
}

async function fetchData(userInputName) {
  console.log("Searching for user: " + userInputName)
  const url = "https://fortnite-api.com/v2/stats/br/v2?name=" + userInputName + "&accountType=epic&timeWindow=lifetime&image=all";
  // fetch(url, { headers: { "Authorization": "d598c2c0-0ef7-40e9-ba23-b49a34262d50" }})
  //   .then((response) => response.json())
  //   .then((data) => console.log(data));
// ----> Had to comment this out to test another method that will work with what I want to do <----
const response = await fetch(url, { headers: { "Authorization": "d598c2c0-0ef7-40e9-ba23-b49a34262d50" }});

if (response.status != 200) {
  document.getElementById("responseStatus").textContent = "Request error " + response.status;
  return;
}

const data = (await response.json()).data;

console.log(data);

document.getElementById("responseStatus").textContent = "Account name: " + data.account.name + "Test";
document.getElementById("resultDiv").style.opacity = 100;
}

