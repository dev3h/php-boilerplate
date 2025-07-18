Lý do tại sao lại dùng composer.json trong dự án php thuần
| Mục đích                                 | Giải thích ngắn gọn                                                 |
| ---------------------------------------- | ------------------------------------------------------------------- |
| **Autoload class (PSR-4)**               | Giúp bạn không phải `require_once` thủ công từng file PHP nữa.      |
| **Quản lý thư viện bên thứ 3**           | Nếu bạn sau này muốn dùng `PHPMailer`, `Dotenv`, `Carbon`, v.v.     |
| **Chuẩn hóa dự án**                      | Ai clone boilerplate của bạn cũng dễ hiểu cách autoload và mở rộng. |
| **Dễ chạy CLI tool**                     | Có thể tạo command như `php artisan`, `php vendor/bin/phpunit`,...  |
| **Mở đường phát triển nâng cao sau này** | Khi team muốn scale, chuyển dần sang kiến trúc lớn hơn.             |

🚫 Khi nào KHÔNG cần composer.json?
| Trường hợp                                       | Giải thích                 |
| ------------------------------------------------ | -------------------------- |
| Dự án nhỏ xíu, không có class, không có autoload | Chỉ cần vài file PHP thuần |
| Chỉ để demo HTML form, xử lý POST đơn giản       | Không cần phức tạp         |
| Không dùng bất kỳ thư viện ngoài nào             | Không quản lý gì thêm      |

→ Nhưng với dự án boilerplate cho nhiều dự án web thực tế như bạn đang làm thì CÓ composer.json là điều hợp lý và khuyến khích.



