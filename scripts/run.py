import sys
import os
import subprocess
import shutil

parent_dir = os.path.abspath(os.path.dirname(os.path.realpath(__file__)) + "/../")

# Ensure we have the required configuration files for the docker services
# FPM
fpm_file = os.path.join(parent_dir, "services", "fpm", "www.conf")
if not os.path.isfile(fpm_file):
    shutil.copyfile(fpm_file + ".dist", fpm_file)

# Xdebug
xdebug_file = os.path.join(parent_dir, "services", "php", "conf.d", "xdebug.ini")
if not os.path.isfile(xdebug_file):
    shutil.copyfile(xdebug_file + ".dist", xdebug_file)

# Nginx
nginx_file = os.path.join(parent_dir, "services", "nginx", "conf.d", "default.conf")
if not os.path.isfile(nginx_file):
    shutil.copyfile(nginx_file + ".dist", nginx_file)

# Base config
compose_config = "-f {docker_compose_file}".format(docker_compose_file=os.path.join(parent_dir, "docker-compose.yml"))

# Extra config files
files = {
#     "build": os.path.join(parent_dir, "docker-compose.build.yml")
}

for file in files.values():
    compose_config += " -f {extra_compose_file}".format(extra_compose_file=file)

# Run the UP command
command = "python3 {ip_update_script} && docker-compose {compose_config} up -d".format(
    ip_update_script=os.path.join(parent_dir, "scripts", "update_www_conf.py"),
    compose_config=compose_config
)

print(command)

subprocess.call(command, shell=True)

# Check if framework is installed
vendor_dir = os.path.join(parent_dir, "app", "vendor")
if not os.path.isdir(vendor_dir):
    import install
