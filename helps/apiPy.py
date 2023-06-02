import requests
import json
url = "https://eu-central-1.aws.data.mongodb-api.com/app/data-xkcms/endpoint/data/v1/action/findOne"

payload = json.dumps({
    "collection": "<COLLECTION_NAME>",
    "database": "<DATABASE_NAME>",
    "dataSource": "Scores",
    "projection": {
        "_id": 1
    }
})
headers = {
  'Content-Type': 'application/json',
  'Access-Control-Request-Headers': '*',
  'api-key': <API_KEY>, 
}

response = requests.request("POST", url, headers=headers, data=payload)

print(response.text)
