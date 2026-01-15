# Persistence
Lưu trữ dữ liệu
Tất cả những thứ liên quan tới việc lưu & đọc dữ liệu.
## ví dụ
MySQL, PostgreSQL, File, Cache, Memory
# Eloquent
Cách lưu trữ cụ thể
## ví dụ
Laravel dùng Eloquent để làm persistence, nên ta ghi rõ:
Persistence bằng Eloquent
Nếu mai này bạn đổi DB hoặc ORM:
Persistence/
   ├─ Eloquent/
   ├─ Doctrine/
   └─ ApiStorage/

php artisan migrate:fresh --seed
php artisan optimize:clear