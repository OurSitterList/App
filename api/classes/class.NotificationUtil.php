<?php

class NotificationUtil
{
    public function NotificationUtil($con)
    {
        $this->mysqlCon = $con;
    }

    public function sendMessage($recipient_id, $user_id, $thread_id)
    {
        $payload = array(
            'type' => 'message',
            'thread_id' => $thread_id,
        );
        $this->send($recipient_id, $user_id, 'New message', 'Someome has sent you a message!', $payload);
    }

    public function sendJobApplication($recipient_id, $user_id, $job_id)
    {
        $payload = array(
            'type' => 'jobApplication',
            'job_id' => $job_id,
        );
        $this->send($recipient_id, $user_id, 'New Job Application', 'A sitter has applied to your job!', $payload);
    }

    public function sendApplicationAccepted($recipient_id, $user_id, $job_id)
    {
        $payload = array(
            'type' => 'jobApplicationAccepted',
            'job_id' => $job_id,
        );
        $this->send($recipient_id, $user_id, 'Accepted Job Application', 'A family has accepted your job application!', $payload);
    }

    public function sendApplicationDeclined($recipient_id, $user_id, $job_id)
    {
        $payload = array(
            'type' => 'jobApplicationDeclined',
            'job_id' => $job_id,
        );
        $this->send($recipient_id, $user_id, 'Declined Job Application', 'A family has declined your job application', $payload);
    }

    private function send($recipient_id, $user_id, $title, $body, $payload)
    {
        $result = $this->mysqlCon->query("SELECT p.push_token, u.user_first_name, u.user_last_name
                                            FROM push_tokens p, user_information u
                                            WHERE p.user_id = '" . $recipient_id . "'
                                            AND u.user_id = '" . $user_id . "'");
        if ($result->num_rows > 0) {
            while ($R = $result->fetch_object()) {
                $messageData = array(
                    'first_name' => $R->user_first_name,
                    'last_name' => $R->user_last_name,
                );
                $token = $R->push_token;
                $data = array(
                    'to' => $token,
                    'title' => $title,
                    'body' => $body,
                    'badge' => 1,
                    'sound' => 'default',
                    'data' => array_merge($payload, $messageData),
                );
                $json = json_encode($data);
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_VERBOSE, false);
                curl_setopt($curl, CURLOPT_URL, "http://ec2-34-228-190-15.compute-1.amazonaws.com:3000/message");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'accept: application/json',
                    'accept-encoding: gzip, deflate',
                    'content-type: application/json',
                ));
                $curl_response = curl_exec($curl);
                curl_close($curl);
            }
        }
    }
}
