# Lab 3: IPsec

- IPsec có:
    - AH: xác thực và toàn vẹn
        - AH transport: để lộ IP, chỉ thêm AH header
        - AH tunnel: che giấu IP bằng cách thêm IP header mới.
    - ESP: xác thực, toàn vẹn, mã hóa.
        - ESP transport: lộ IP
        - ESP tunnel: che giấu IP bằng cách thêm IP header
    - IKE: giao thức thiết lập kết nối, bắt thay và xác thực mật khẩu, trao đổi khóa
        - b1: (IKE SA) tạo một đường hầm để quản lý, xác thực danh tính, thỏa thuật thuật  toán băm/mã hóa, tạo SPI
        - b2: (child SA): tùy thuộc vào 4 chế độ

![image.png](./images/image.png)

### 1. AH transport

![image.png](./images/image 1.png)

- Cài đặt công cụ strongswan
- tạo PSK cho cả 2 máy
    
    ![image.png](./images/image 2.png)
    
    ![image.png](./images/image 3.png)
    
- sửa /etc/ipsec.conf máy server (10.3.51.10)
    
    ```jsx
    conn transportAH
    	type=transport
    	left=10.3.51.10
    	right=10.3.51.20
    	authby=secret
    	ah=aes128-sha1
    	auto=start
    ```
    
    ![image.png](./images/image 4.png)
    
    tương tự với máy client
    
    ```jsx
    conn transportAH
    	type=transport
    	left=10.3.51.20
    	right=10.3.51.10
    	authby=secret
    	ah=aes128-sha1
    	auto=start
    ```
    
    ![image.png](./images/image 5.png)
    
- ipsec stop
- ipsec start
- ipsec status
- server tới client
    
    ![image.png](./images/image 6.png)
    
    ![image.png](./images/image 7.png)
    
- client tới server
    
    ![image.png](./images/image 8.png)
    
    ![image.png](./images/image 9.png)
    

### 2. ESP transport

- server

![image.png](./images/image 10.png)

```jsx
conn transportESP
	type=transport
	left=10.3.51.10
	right=10.3.51.20
	authby=secret
	esp=aes128-sha1
	auto=start
```

![image.png](./images/image 11.png)

- client

![image.png](./images/image 12.png)

```jsx
conn transportESP
	type=transport
	left=10.3.51.20
	right=10.3.51.10
	authby=secret
	esp=aes128-sha1
	auto=start
```

![image.png](./images/image 13.png)

### 3. AH tunnel

- server
    
    ```jsx
    conn tunnelAH
    	type=tunnel
    	left=10.3.51.10
    	right=10.3.51.20
    	authby=secret
    	ah=aes128-sha1
    	auto=start
    ```
    
    ![image.png](./images/image 14.png)
    
    ![image.png](./images/image 15.png)
    
- client
    
    ```jsx
    conn tunnelAH
    	type=tunnel
    	left=10.3.51.20
    	right=10.3.51.10
    	authby=secret
    	ah=aes128-sha1
    	auto=start
    ```
    

![image.png](./images/image 16.png)

![image.png](./images/image 17.png)

### 4. ESP tunnel

- server
    
    ```jsx
    conn tunnelESP
    	type=tunnel
    	left=10.3.51.10
    	right=10.3.51.20
    	authby=secret
    	esp=aes128-sha1
    	auto=start
    ```
    

![image.png](./images/image 18.png)

![image.png](./images/image 19.png)

- client
    
    ```jsx
    conn tunnelESP
    	type=tunnel
    	left=10.3.51.20
    	right=10.3.51.10
    	authby=secret
    	esp=aes128-sha1
    	auto=start
    ```
    

![image.png](./images/image 20.png)

![image.png](./images/image 21.png)