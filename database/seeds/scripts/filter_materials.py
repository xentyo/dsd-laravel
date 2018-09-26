import os
import csv

current_folder = os.path.dirname(os.path.abspath(__file__))

csv_materials = current_folder + "\\csv\\materials.csv"

with open(csv_materials, newline="\n", encoding="utf8") as csvfile:
    reader = csv.DictReader(csvfile, delimiter=",")
    names = []
    for row in reader:
        if(row['name'] not in names and " " not in row['name']):
            names.append(row['name'])
    print(names)
