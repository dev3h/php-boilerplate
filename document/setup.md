# 1 Tạo các folder
```bash
php-boilerplate/
├── public/                 # Nơi chứa index.php, entry point
│   ├── .htaccess             # Apache rewrite
│   └── index.php         # Entry point của ứng dụng, chứa khởi tạo Route, các khởi tạo từ bootstrap/app.php
├── app/                    # Mã nguồn chính
│   ├── Controllers/       # Chứa các controller
│   ├── Services/          # Chứa các service
│   ├── Repositories/      # Chứa các repository
│   ├── Core/               # Class chung (DB, Router, View, Request,...)
│   │   └── Router.php
│   │   └── View.php
│   │   └── Database.php
│   ├── Views/         # Thư mục chứa các view
├── bootstrap/              # Thư mục khởi tạo ứng dụng
│   └── app.php          # Nơi khởi tạo các thành phần cần thiết (env, autoload)
├── routes/                 # Định nghĩa các route
│   └── web.php
├── Database/               # Chứa các migration và seed
│   └── migrations/
└── migrate.php             # File thực hiện migrate
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
- **Core\Router.php**: Class Router để xử lý các route.
- **web.php**: File định nghĩa các route của ứng dụng.

# 4 Tạo file index.php trong folder public
- File index.php sẽ là entry point của ứng dụng, nơi sẽ khởi tạo các thành phần cần thiết như Router, autoload, load env

# 5 Tạo file .htaccess trong folder public
- Mục đích của file này là để cấu hình Apache server, cho phép sử dụng URL thân thiện và chuyển hướng tất cả các yêu cầu đến index.php.

# 6 Thiết lập view
- Từ controller, get tất cả dữ liệu cần thiết, sau đó require đến màn hình view
- Tuy nhiên, để tối ưu hơn, ta sẽ tạo một class View trong Core, để xử lý việc render view và truyền dữ liệu vào view.

# 7 Config DB
- Tạo 1 cái core Database để thực hiện kết nối đến DB, áp dụng design pattern singleton để chỉ có một instance duy nhất của Database.
- Tạo file config/database.php để chứa các thông tin kết nối đến cơ sở dữ liệu.
- Để đảm bảo tính bảo mật, tiến hành load các biến môi trường từ file .env, sử dụng package `vlucas/phpdotenv`.

# 8 .env
- Tự động load biến .env sử dụng `vlucas/phpdotenv` package.

```bash
composer require vlucas/phpdotenv
```

# 9 Tạo fn route trong Core\Router.php để xử lý bên frontend
- Trong frontend, mong muốn là sử dụng được route('route_name') để lấy ra URL của route đó.
- Ta sẽ tạo 1 hàm route trong Core\Router.php để xử lý việc này. Sau đó tạo 1 file helpers trong folder Helpers để xử lý khi người dùng sử dụng bên fronend thì sẽ gọi hàm để lấy ra URL của route.
- Để có thể dùng hàm của helpers, ta sẽ autoload file helpers này trong composer.json.
```json
"autoload": {
    "files": [
        "app/Helpers/helpers.php"
    ]
}
```

# 10 Tạo Core\Validator.php để xử lý validate
- Tạo class Validator trong Core để xử lý validate dữ liệu.
- Tạo thêm 1 hàm `validate` trong file helpers để sử dụng dễ dàng hơn.
- Trong quá trình trả về lỗi trong controller, ta cần handle validate lỗi sẽ trả về dưới dạng session_flash cũng như dữ liệu cũ mà người dùng đã nhập vào
- Ta tạo hàm `old` trong file helpers để lấy dữ liệu cũ từ session flash. hàm `flash` sẽ lấy dữ liệu từ session flash và xóa nó sau khi đã lấy ra. Hàm `set_old` sẽ lưu dữ liệu cũ vào session flash để có thể sử dụng lại sau này.

# 11 Tạo script migrate
- Tạo file `migrate.php` trong thư mục gốc để thực hiện migrate