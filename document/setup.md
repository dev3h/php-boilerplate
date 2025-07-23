# 1 Tạo các folder
```bash
php-boilerplate/
├── public/                 # Nơi chứa index.php, entry point
│   ├── .htaccess             # Apache rewrite
│   └── index.php
├── app/                    # Mã nguồn chính
│   ├── Controllers/       # Chứa các controller
│   ├── Core/               # Class chung (DB, Router, View, Request,...)
│   │   └── Router.php
│   │   └── View.php
│   ├── Views/         # Thư mục chứa các view
├── routes/                 # Định nghĩa các route
│   └── web.php
├── config/                 # Cấu hình DB, app
├── vendor/                 # Composer packages
└── composer.json
```

# 2 Tạo init composer
```bash
composer init
```

Sau khi chạy xong thì sẽ chạy lệnh cập nhập autoload
```bash	
composer dump-autoload
```

# 3 Tạo file Router.php, web.php
- **Router.php**: Class Router để xử lý các route.
- **web.php**: File định nghĩa các route của ứng dụng.
# 4 Tạo file index.php trojg folder public

# 5 Tạo file .htaccess trong folder public

# env
dùng getenv() không được, phải dùng $_ENV['KEY'] để lấy giá trị từ file .env. 
Tại sao? Vì getenv() chỉ lấy giá trị từ biến môi trường đã được thiết lập trong hệ thống, trong khi $_ENV là mảng chứa các biến môi trường đã được nạp từ file .env.
