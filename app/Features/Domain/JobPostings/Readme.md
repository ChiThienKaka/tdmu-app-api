# LUẬT NGHIỆP VỤ ĐĂNG BÀI TUYỂN DỤNG

## 1 Bài post KHÔNG BAO GIỜ BỊ XÓA
Gói hết hạn → chỉ ẨN, không delete
Dữ liệu ứng tuyển & lịch sử phải giữ

## 2 Điều kiện bài được hiển thị (Public)
Bài hiển thị khi ĐỒNG THỜI:
job_posts.status = approved
subscription.status = active
subscription.end_date >= today
=> Sai 1 điều → ẨN

## 3 Gói hết hạn
subscription.status = expired
Toàn bộ bài thuộc gói → job_posts.status = expired
Recruiter vẫn thấy trong dashboard

## 4 Gia hạn gói
Không tạo gói mới
Cập nhật end_date
Bài expired → cho đăng lại (pending → approved)

## 5 Đổi gói (Basic → Pro, Pro → Premium)
❌ Không update gói cũ
✅ Tạo recruiter_subscriptions mới
Bài cũ giữ nguyên subscription cũ
Muốn dùng gói mới → tạo bài mới / clone

## 6 Giới hạn số bài (post_limit)
Đã đủ số bài approved/pending:
❌ Không cho publish
✅ Cho tạo draft
Hiển thị cảnh báo nâng cấp gói

## 7 Tin VIP / Featured
Chỉ được bật nếu:
featured_posts_limit còn
Gói còn hạn
Gói hết hạn → tự động:
is_featured = false
priority_level = 0

## 8 Đóng tuyển (KHÔNG liên quan gói)
Recruiter chủ động set:
status = closed
Không cho apply
Có thể vẫn cho xem (tuỳ bạn)

## 9 Quy tắc vàng để code không rối
❌ Không xóa job
❌ Không sửa gói cũ khi đổi gói
✅ Chỉ thay đổi status
✅ Mọi hiển thị = check trạng thái

## 10 User reload 100 lần vẫn chỉ tính 1 view 
→ Không cho trùng