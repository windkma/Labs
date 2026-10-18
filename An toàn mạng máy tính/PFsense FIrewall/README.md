# Triển khai tường lửa Pfsense

![image.png](./images/image.png)

- vào giao diện cấu hình của Pfsense để cấu hình, thông tin về cổng mạng
    
    ![image.png](./images/image%201.png)
    

### 1. Kịch bản 0. Xóa các rule mặc định

- truy cập Firewall 🡪 Rules 🡪 LAN

![image.png](./images/image%202.png)

- xóa các rule mặc định, chỉ còn lại rule cho quản trị firewall

![image.png](./images/image%203.png)

### 2. Kịch bản 1. *Cho phép máy trạm trong mạng LAN Ping ra Internet*

- kiểm tra ping trước khi tạo rule

![image.png](./images/image%204.png)

→ không thể ping vì bị firewall chặn

- add thêm rule sau
    
    ![image.png](./images/image%205.png)
    
    ![image.png](./images/image%206.png)
    
- chọn save để lưu
    
    ![image.png](./images/image%207.png)
    
- ping kiểm tra lại, kết quả là đã ping được
    
    ![image.png](./images/image%208.png)
    

### 2. Kịch bản 2. *Cho phép máy tính trong mạng LAN truy vấn DNS ra Internet*

- add rule sau

![image.png](./images/image%209.png)

![image.png](./images/image%2010.png)

![image.png](./images/image%2011.png)

- kiểm tra

![image.png](./images/image%2012.png)

### 3. ***Kịch bản 3:** Cho phép máy tính trong mạng LAN truy cập website qua cổng 80, 443.*

![image.png](./images/image%2013.png)

- truy cập website bằng win 7
    
    ![image.png](./images/image%2014.png)
    

### 4. ***Kịch bản 4:** Cho phép máy tính ngoài Internet truy cập vào website trên máy chủ DMZ*

- chuyển qua giao diện cấu hình cho WAN, bỏ 2 rule mặc định được tạo sẵn trong mạng wan bằng cách vào setting bỏ 2 tùy chọn sau
    
    ![image.png](./images/image%2015.png)
    
- vào phần ADD để tạo rule
    
    ![image.png](./images/image%2016.png)
    
    ![image.png](./images/image%2017.png)
    
    ![image.png](./images/image%2018.png)
    
- Để người dùng ngoài có thể truy cập được cần thực hiện NAT từ ngoài vào trong máy web server. Vào Firewall → NAT và tạo rule sau
    
    ![image.png](./images/image%2019.png)
    
    ![image.png](./images/image%2020.png)
    
- tại máy vật lý, truy cập vào ip của firewall
    
    ![image.png](./images/image%2021.png)
