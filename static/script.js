function getInput() {
    var userInputName = document.getElementById("usern").value;
    if (userInputName == "") { window.alert("No input found") }
    else {
        fetchData(userInputName);
    }
}

function fetchData(userInputName) {
  console.log(userInputName)
  const url = "https://fortnite-api.com/v2/stats/br/v2?name=" + userInputName + "&accountType=epic&timeWindow=lifetime&image=all";
  fetch(url, { headers: { "Authorization": "d598c2c0-0ef7-40e9-ba23-b49a34262d50" }})
    .then((response) => response.json())
    .then((data) => console.log(data));

}

