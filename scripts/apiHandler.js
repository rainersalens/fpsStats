require('dotenv').config();

async function callFortniteApiAndGetResponse(searchName, accountType) {

  const data = new URLSearchParams();
  data.append('name', searchName);
  data.append('accountType', accountType);
  
  const response = await fetch("https://fortnite-api.com/v2/stats/br/v2?" + data,
    {
      method: "GET",
      headers: {
        "Authorization": process.env.FORTNITE_API_KEY,
      }
    });

  return response;
}

async function callApexLegendsApiAndGetResponse(username, platform) {

  const data = new URLSearchParams();
  data.append('player', username);
  data.append('platform', platform);
  
  const response = await fetch("https://api.mozambiquehe.re/bridge?" + data,
    {
      method: "GET",
      headers: {
        "Authorization": process.env.APEX_LEGENDS_API_KEY,
      }
    });

  return response;
}

module.exports = {
  callFortniteApiAndGetResponse,
  callApexLegendsApiAndGetResponse
};
