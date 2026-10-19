# Lab 6: SMTP, POP3

POP3 (post office protocol v3): để lấy thư từ server về máy, sau khi lấy thì mail trên server sẽ bị xóa

IMAP (internet message access protocol) : giúp lấy thư về không bị xóa trên server

SMTP : gửi thư từ client lên server 

- mdaemon: smtp gửi thư lên server qua port 25, pop3 nhận thư về qua port 110

- trên win 10 download thnderbird
- trên win server download thunderbird và download mdaemon [https://drive.google.com/drive/folders/1lE7LBZaw1_0NMSgO5p-Dxn9Ik4mUcwl5?hl=vi](https://drive.google.com/drive/folders/1lE7LBZaw1_0NMSgO5p-Dxn9Ik4mUcwl5?hl=vi)
- tạo dns
    
    ![image.png](./images/image.png)
    
- tạo bản ghi MX
    
    ![image.png](./images/image%201.png)
    
- tạo domain name
    
    ![image.png](./images/image%202.png)
    
- cài đặt mdaemon
- triển khai 2 user
    
    user1@phanthephong-srv.class3
    
    user2@phanthephong-srv.class3 
    
    ![image.png](./images/image%203.png)
    
- tạo tài khoản trên thunderbird
    
    ![image.png](./images/image%204.png)
    
    ![image.png](./images/image%205.png)
    
- đăng nhập user2 trên win 10
    
    ![image.png](./images/image%206.png)
    
- gửi thư từ user2 sang user1
    
    ![image.png](./images/image%207.png)
    
- đã nhận được thư
    
    ![image.png](./images/image%208.png)
    
- trả lời lại
    
    ![image.png](./images/image%209.png)
    
- đã nhận đc thư trả lời
    
    ![image.png](./images/image%2010.png)