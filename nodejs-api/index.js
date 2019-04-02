const { JWT } = require("google-auth-library");
const https = require("https");
const bodyParser = require("body-parser");

const key = require("./service-account.json");

const express = require("express");
const app = express();
const port = 3000;

app.use(bodyParser.json());

app.get("/", (req, res) => res.send("YES"));
app.post("/message", (req, res) => {
  const { to, title, body, badge, sound, data } = req.body;
  getAccessToken()
    .then(token => {
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
        res.status(500).json(err);
      });

      request.write(
        JSON.stringify({
          message: {
            token: to,
            notification: {
              title,
              body
            },
            data,
            apns: {
              headers: {
                "apns-priority": "10"
              },
              payload: {
                aps: {
                  sound: "default"
                }
              }
            },
            android: {
              priority: "high",
              notification: {
                sound: "default"
              }
            }
          }
        })
      );
      request.end();

      res.status(200).json({ message: "SUCCESS" });
    })
    .catch(err => res.status(500).json(err));
});

app.listen(port, () => console.log(`NodeJS listening on port ${port}!`));

function getAccessToken() {
  return new Promise(function(resolve, reject) {
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
      console.log({ tokens });
      resolve(tokens.access_token);
    });
  });
}
