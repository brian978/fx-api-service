import socket


def get_ip() -> str:
    socket_obj = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    socket_obj.connect(("8.8.8.8", 80))

    return str(socket_obj.getsockname()[0])
