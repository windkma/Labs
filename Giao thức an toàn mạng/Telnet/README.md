# Lab 4: Telnet

![image.png](./images/image.png)

- tải telnetd
- thêm vào file cấu hình trên server
    
    ```jsx
    echo "telnet stream tcp nowait root /usr/sbin/telnetd telnetd" | sudo tee -a /etc/inetd.conf
    systemctl daemon-reload
    systemctl restart inetutils-inetd
    ```
    
    ![image.png](./images/image%201.png)
    
- tạo domain name cho server

![image.png](./images/image%202.png)

- đăng nhập telnet từ client
    
    ```jsx
    telnet 10.3.51.9 
    ```
    
    ![image.png](./images/image%203.png)