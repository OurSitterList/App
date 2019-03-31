const { JWT } = require("google-auth-library");
const https = require("https");

function getAccessToken() {
  return new Promise(function(resolve, reject) {
    const key = require("./service-account.json");
    const jwtClient = new JWT(
      key.client_email,
      null,
      key.private_key,
      [
        "https://www.googleapis.com/auth/cloud-platform",
        "https://www.googleapis.com/auth/firebase.messaging"
      ],
      null
    );
    jwtClient.authorize(function(err, tokens) {
      if (err) {
        reject(err);
        return;
      }
      resolve(tokens.access_token);
    });
  });
}

getAccessToken().then(token => {
  const options = {
    hostname: "fcm.googleapis.com",
    path: "/v1/projects/our-sitter-list-30509/messages:send",
    method: "POST",
    headers: {
      Authorization: `Bearer ${token}`,
      "Content-Type": "application/json"
    }
  };

  const request = https.request(options, function(resp) {
    resp.setEncoding("utf8");
    resp.on("data", function(data) {
      console.log("Message sent to Firebase for delivery, response:");
      console.log(data);
    });
  });

  request.on("error", function(err) {
    console.log("Unable to send message to Firebase");
    console.log(err);
  });

  const fcmMessage = {
    message: {
      token:
        "de_6JQhf9TM:APA91bF9sWgjLIqq66k99RVFzQFGvczWmmEosgs1oWZN9ECXkLqplb_LVfovhwLGLkAUWZ6-eMOrqpU-zbcFfUYCh7cmtMroh1LRMsqW8LFLoIHFAK_Uxrt5xKP8nvZIlRifUHP02Yol",
      notification: {
        title: "Breaking News",
        body: "New news story available."
      },
      data: {
        thread_id: "sdfvmksdfknjl"
      }
    }
  };

  request.write(JSON.stringify(fcmMessage));
  request.end();
});
