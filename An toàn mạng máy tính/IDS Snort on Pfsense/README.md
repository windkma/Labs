# Triển khai IDS Snort trên Pfsense

![image.png](./images/image.png)

### 1. Tích hợp IDS snort vào pfsense

- tải gọi snort vào pfsense
    
    ![image.png](./images/image%201.png)
    
    ![image.png](./images/image%202.png)
    
- tải rule cho snort
    
    ![image.png](./images/image%203.png)
    
    ![image.png](./images/image%204.png)
    
- GPLv2 là bộ rules của cộng đồng snort chứa các signature nhận diện các cuộc tấn công phổ biến.
    
    ![image.png](./images/image%205.png)
    
- Sourcefire OpenAppID Detectors là cấu hình nhận diện gói tin ở tầng application.
- Chuyển sang Tab Updates, chọn Update Rules để tải về tập luật đã lựa chọn
- Chuyển sang Tab Snort Interfaces, tạo Interface WAN (chọn Add): tức là theo dõi và phát hiện xâm nhập từ lưu lượng đi vào cổng WAN.
    
    ![image.png](./images/image%206.png)
    
    ![image.png](./images/image%207.png)
    

### 2. Tấn công thử nghiệm

- sử dụng nmap từ máy thật để tấn công vào máy windows server
    
    ![image.png](./images/image%208.png)
