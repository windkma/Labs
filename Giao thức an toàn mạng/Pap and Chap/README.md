# Lab 1 Pap Chap

### 1. PAP

![image.png](./images/image.png)

- bật `encapsulation PPP`

![image.png](./images/image 1.png)

![image.png](./images/image 2.png)

- Tạo tài khoản để xác thực PTP2 và bật PAP trên PTP1
    
    ![image.png](./images/image 3.png)
    
- cấu hình gửi username và pass từ PTP2 cho PTP1 với tài khoản đã tạo ở trên để PPT1 tự động xác thực PTP2
    
    ![image.png](./images/image 4.png)
    
- shutdown interface và kiểm tra xem đã bật authentication chưa
    
    ![image.png](./images/image 5.png)
    
    ![image.png](./images/image 6.png)
    
- Tương tự
    
    ![image.png](./images/image 7.png)
    
    ![image.png](./images/image 8.png)
    
    ![image.png](./images/image 9.png)
    
- Xác thực 2 chiều thành công trên wireshark
    
    ![image.png](./images/image 10.png)
    
    - gói tin 20 gửi thông tin danh tính từ PTP2 tới PTP1 với username và password
    - gói số 21 gửi ngược lại từ PTP1 tới PTP2
    - gói 22 và là lời chấp thuận từ 2 phía (ack)

### 2. CHAP

- Cấu hình PTP1

![image.png](./images/image 11.png)

- Cấu hình PTP2

![image.png](./images/image 12.png)

![image.png](./images/image 13.png)