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
    
    ![image.png](./images/image 1.png)
    
- tạo domain name
    
    ![image.png](./images/image 2.png)
    
- cài đặt mdaemon
- triển khai 2 user
    
    user1@phanthephong-srv.class3
    
    user2@phanthephong-srv.class3 
    
    ![image.png](./images/image 3.png)
    
- tạo tài khoản trên thunderbird
    
    ![image.png](./images/image 4.png)
    
    ![image.png](./images/image 5.png)
    
- đăng nhập user2 trên win 10
    
    ![image.png](./images/image 6.png)
    
- gửi thư từ user2 sang user1
    
    ![image.png](./images/image 7.png)
    
- đã nhận được thư
    
    ![image.png](./images/image 8.png)
    
- trả lời lại
    
    ![image.png](./images/image 9.png)
    
- đã nhận đc thư trả lời
    
    ![image.png](./images/image 10.png)