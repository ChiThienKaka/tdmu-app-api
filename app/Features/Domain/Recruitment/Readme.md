# Database
recruiter_packages
recruiter_subscriptions
payment_transactions
recruiter_notifications
# Set up
Cấu hình Provider của module ra ngoài để dùng

# FLOW
- Danh sách gói tuyển dụng cho nhà tuyển dụng (Basic, Pro, Vip)
1. Recruiter đăng ký tài khoản 
2. Cho người dùng tự chọn gói 
3. Cho người dùng thanh toán
3. Recruiter điền thông tin công ty 
4. Recruiter đăng tin (dùng quota của gói) 
5. Khi hết quota → upgrade gói

# LUẬT NGHIỆP VỤ BẤT BIẾN (đọc kỹ)
1 recruiter tại 1 thời điểm chỉ có 1 subscription ACTIVE
Không bao giờ ACTIVE nếu chưa thanh toán
Pending = đang có giao dịch → cấm tạo mới
Mọi thay đổi gói đều đi qua payment
DB luôn là tuyến phòng thủ cuối cùng
## TRƯỜNG HỢP 1: CHƯA CÓ SUBSCRIPTION → ĐĂNG KÝ MỚI
## TRƯỜNG HỢP 2: ĐANG ACTIVE → GIA HẠN (SAME PACKAGE)
## TRƯỜNG HỢP 3: ĐANG ACTIVE → NÂNG CẤP (UPGRADE)
## TRƯỜNG HỢP 4: ĐANG PENDING → KHÔNG ĐƯỢC LÀM GÌNguyên tắc sống còn:
### 1 user chỉ được có 1 subscription active hoặc pending tại 1 thời điểm

# Set up cloudflared
https://developers.cloudflare.com/cloudflare-one/networks/connectors/cloudflare-tunnel/downloads/
# Login
Account home -> Zero Trust -> chọn option này Protect your applications (Access)

