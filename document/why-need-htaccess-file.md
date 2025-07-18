## Tại sao cần file .htaccess trong thư mục public
1. Mục đích chính của .htaccess

File .htaccess giúp Apache Web Server hiểu cách xử lý các URL gửi tới ứng dụng. Khi ta sử dụng mô hình MVC (Model - View - Controller), tất cả các request thường được chuyển hướng về một file duy nhất (thường là index.php) để Router xử lý tiếp.

👉 Vì vậy, .htaccess đóng vai trò viết lại URL (URL rewriting), từ đường dẫn ảo về index.php.

2. Vị trí đặt file .htaccess

File .htaccess nên được đặt trong thư mục public/, vì đây là thư mục gốc của ứng dụng khi chạy trên web. Mọi request sẽ được gửi đến thư mục public, và Apache sẽ dùng .htaccess tại đây để xử lý.

3. Nội dung phổ biến của .htaccess

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Nếu file hoặc thư mục không tồn tại, thì chuyển hướng về index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    RewriteRule ^ index.php [QSA,L]
</IfModule>
```
Giải thích:
- RewriteEngine On: Bật chế độ viết lại URL.
- RewriteCond %{REQUEST_FILENAME} !-f: Nếu không phải là file thật trên server...
- RewriteCond %{REQUEST_FILENAME} !-d: ... và cũng không phải thư mục thật...
- RewriteRule ^ index.php [QSA,L]: ... thì chuyển hướng toàn bộ request đến index.php.

Giải thích chi tiết:
```apache
<IfModule mod_rewrite.c>
```
Dòng này kiểm tra xem module mod_rewrite của Apache có được bật hay không.
- mod_rewrite là module giúp Apache thực hiện việc viết lại URL (rewrite).
- Nếu module này không tồn tại, toàn bộ đoạn mã bên trong sẽ bị bỏ qua, tránh lỗi.

```apache
RewriteEngine On
```
- Dòng này bật chức năng rewrite của Apache.
- Nếu không có dòng này, các RewriteRule sẽ không có tác dụng.

```apache
RewriteCond %{REQUEST_FILENAME} !-f
```
- Chỉ thực hiện rewrite nếu request không trỏ tới một file thật sự trên server (! -f nghĩa là không phải file).
Ví dụ:
- /favicon.ico là file thật → không rewrite.
- /about không phải file thật → tiếp tục kiểm tra dòng tiếp theo.

```apache
RewriteCond %{REQUEST_FILENAME} !-d
```
- Chỉ thực hiện rewrite nếu request không trỏ đến thư mục thật (! -d nghĩa là không phải thư mục).

Ví dụ:

- /images/ là thư mục thật → không rewrite.
- /blog/post/123 không tồn tại trên ổ cứng → tiếp tục rewrite.

```apache
RewriteRule ^ index.php [QSA,L]
```
Đây là quy tắc viết lại URL:
- Nếu các điều kiện trên thỏa mãn, thì rewrite tất cả URL về index.php.
- 🔍 Các thành phần:
    - ^ là pattern regex: mọi đường dẫn bắt đầu từ đầu dòng.
    - index.php là file đích sau khi rewrite.
    - [QSA,L] là các flag:
        - QSA (Query String Append): nếu URL có query string (ví dụ ?id=5), thì giữ lại và nối vào sau index.php.
        - L (Last rule): không xét các RewriteRule tiếp theo nữa – dừng lại ở đây.

4. Kết luận

Nếu không có file .htaccess, những đường dẫn như:

```
http://base.local/home
```
sẽ bị Apache hiểu là đang yêu cầu một thư mục/file home trong public/. Nếu không tồn tại, sẽ trả lỗi 404 Not Found.

Nhờ có .htaccess, các request này sẽ được chuyển về index.php để framework của bạn xử lý tiếp.

## Tại sao lại là file .htaccess?
1 .htaccess là viết tắt của HyperText Access
Tên đầy đủ: HyperText Access file
- Đây là một file cấu hình cấp thư mục được Apache hỗ trợ, cho phép bạn điều chỉnh cách server xử lý request ngay tại thư mục đó, mà không cần sửa file cấu hình chính (httpd.conf) của Apache.

2 Dấu chấm đầu tiên (.) nghĩa là gì?
- Trong hệ điều hành Linux/Unix, khi một file bắt đầu bằng dấu chấm (.), nó trở thành file ẩn (hidden file).
- Việc đặt tên là .htaccess giúp ẩn file khỏi người dùng thông thường, tránh chỉnh sửa hoặc xóa nhầm.

3 Apache tự động tìm .htaccess ở từng thư mục
- Khi có một request đến, Apache sẽ kiểm tra thư mục tương ứng xem có file .htaccess hay không.
- Nếu có, nó sẽ áp dụng các quy tắc rewrite, redirect, phân quyền... từ file đó cho request đang xử lý.

4 Vì sao không dùng tên khác?
- Apache mặc định chỉ nhận diện đúng tên .htaccess, trừ khi bạn cấu hình lại bằng AccessFileName trong httpd.conf (hiếm khi làm).
- Do đó, để mọi cấu hình rewrite, redirect, hoặc bảo mật thư mục hoạt động đúng, bạn phải đặt đúng tên là .htaccess.