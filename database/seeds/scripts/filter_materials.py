import csv
import json

f = open('data/materials.json', 'w')

with open("data/materials.csv", 'r') as csvfile:
    array = []
    reader = csv.DictReader(csvfile, delimiter=",", fieldnames=['id', 'name'])
    for row in reader:
        array.append({
            'id': row['id'],
            'name' : row['name']
        })
    json.dump(array, f)
