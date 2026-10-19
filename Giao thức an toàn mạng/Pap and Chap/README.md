# Lab 1 Pap Chap

### 1. PAP

![image.png](./images/image.png)

- bật `encapsulation PPP`

![image.png](./images/image%201.png)

![image.png](./images/image%202.png)

- Tạo tài khoản để xác thực PTP2 và bật PAP trên PTP1
    
    ![image.png](./images/image%203.png)
    
- cấu hình gửi username và pass từ PTP2 cho PTP1 với tài khoản đã tạo ở trên để PPT1 tự động xác thực PTP2
    
    ![image.png](./images/image%204.png)
    
- shutdown interface và kiểm tra xem đã bật authentication chưa
    
    ![image.png](./images/image%205.png)
    
    ![image.png](./images/image%206.png)
    
- Tương tự
    
    ![image.png](./images/image%207.png)
    
    ![image.png](./images/image%208.png)
    
    ![image.png](./images/image%209.png)
    
- Xác thực 2 chiều thành công trên wireshark
    
    ![image.png](./images/image%2010.png)
    
    - gói tin 20 gửi thông tin danh tính từ PTP2 tới PTP1 với username và password
    - gói số 21 gửi ngược lại từ PTP1 tới PTP2
    - gói 22 và là lời chấp thuận từ 2 phía (ack)

### 2. CHAP

- Cấu hình PTP1

![image.png](./images/image%2011.png)

- Cấu hình PTP2

![image.png](./images/image%2012.png)

![image.png](./images/image%2013.png)