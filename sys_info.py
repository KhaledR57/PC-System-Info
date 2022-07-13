import hashlib
import os
import sys

import uuid
import requests
import wmi
import json

base_url = 'http://127.0.0.1:8000/api/v1/'


#################################################### Authorization ####################################################
email = "banana_moz@abc.com"
password = input("Enter Password:")

cred = {
    "email" : email,
    "password" : password
}

def to(route):
    return base_url + route

res = requests.post(to("login"), json=cred)

try:
    token = json.loads(res.text)["data"]["token"]
except:
  print("Unauthorised :(")
  sys.exit()

headers = {"Authorization": f"Bearer {token}" }


#################################################### Collect Data ####################################################

def getMachine_addr():
	command = "wmic bios get serialnumber"
	return os.popen(command).read().replace("\n","").replace("	","").replace(" ","")

computer = wmi.WMI()
computer_info = computer.Win32_ComputerSystem()[0]
os_info = computer.Win32_OperatingSystem()[0]
proc_info = computer.Win32_Processor()[0]
gpu_info = computer.Win32_VideoController()[0]
disk_info = computer.Win32_DiskDrive()[0]
model_info = computer.Win32_ComputerSystem()[0]

temp_info = computer.Win32_VideoController()[0]

os_name = os_info.Name.split('|')[0]
os_version = ' '.join([os_info.Version, os_info.BuildNumber])
system_ram = round(float(os_info.TotalVisibleMemorySize) / 1048576)  # KB to GB
serial_number = getMachine_addr() + str(hex(uuid.getnode()))


#print('OS Name: {0}'.format(os_name))
#print('OS Version: {0}'.format(os_version))
#print('CPU: {0}'.format(proc_info.Name))
#print('RAM: {0} GB'.format(system_ram))
#print('Graphics Card: {0}'.format(gpu_info.Name))
#print('Disk Drive Model: {0}'.format(disk_info.Model))
#print('Laptop Model: {0}'.format(model_info.SystemFamily))
#print('Laptop Model: {0}'.format(temp_info))

#################################################### Send Data ####################################################

pc = {
    'os_name': os_name,
    'os_version': os_version,
    'proc_info': proc_info.Name,
    'gpu_info': gpu_info.Name,
    'disk_info': disk_info.Model,
    'system_ram': system_ram,
    'model_info': model_info.SystemFamily,
    'hash' : hashlib.md5((os_name + os_version + proc_info.Name + gpu_info.Name + disk_info.Model + str(system_ram) + model_info.SystemFamily).encode()).hexdigest(),
    'serial' : serial_number,
    'created_by' : email
}

res = requests.post(to("computers"), json=pc, headers=headers)
print(res.text)
#################################################### End ####################################################
