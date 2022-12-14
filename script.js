// First 2 lines is for the button functionality
var timeFrame = 1;

function getInput() {
  var userInputName = document.getElementById("usern").value;
  if (userInputName == "") { window.alert("No input found") }
  else {
    fetchData(userInputName);
  }
}

async function fetchData(userInputName) {

  if (timeFrame == 0) {
    var usedTimeFrame = "season";
  } else {
    var usedTimeFrame = "lifetime";
  }

  console.log("Searching for user: " + userInputName)
  const url = "https://fortnite-api.com/v2/stats/br/v2?name=" + userInputName + "&accountType=epic&timeWindow=" + usedTimeFrame + "&image=all";
  const response = await fetch(url, { headers: { "Authorization": "d598c2c0-0ef7-40e9-ba23-b49a34262d50" } });

  if (response.status != 200) {
    document.getElementById("responseStatus").textContent = "Request error " + response.status;
    document.getElementById("resultDiv").style.opacity = 100;
    return;
  }

  const data = (await response.json()).data;

  console.log(data);

  document.getElementById("responseStatus").innerHTML =
    "Account name: " + data.account.name + "<br>"
    + "Account ID: " + data.account.id + "<br>"
    + "<br>"
    + "Showing stats for " + usedTimeFrame + "<br>"
    + "Solo k/d: " + data.stats.all.solo?.kd + "<br>"
    + "Duos k/d: " + data.stats.all.duo?.kd + "<br>"
    + "Squads k/d: " + data.stats.all.squad?.kd + "<br>";


  document.getElementById("resultDiv").style.opacity = 100;
}

