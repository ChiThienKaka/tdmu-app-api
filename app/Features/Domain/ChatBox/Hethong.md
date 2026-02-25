# 🧠 Kiến trúc chuẩn: 2 tầng hiểu user

Think chatbot như:

Layer 1 → Intent router (FAQ)
Layer 2 → Knowledge search (RAG embedding)
## 🎯 Layer 1 — FAQ intent router

Dùng khi:

👉 user muốn thực hiện hành động
👉 cần query DB thật
👉 logic backend

Ví dụ user hỏi:

tôi apply job nào rồi?

→ đây là hành vi hệ thống:

intent = my_applications

→ router → DB → trả dữ liệu thật

KHÔNG cần embedding search.

## 🎯 Layer 2 — RAG embedding search

Dùng khi:

👉 user hỏi kiến thức
👉 thông tin mô tả
👉 nội dung văn bản

Ví dụ:

công ty ABC làm gì?
yêu cầu backend intern là gì?

→ semantic search trong vector DB.

🔥 Flow production thật
User message
↓
Intent matcher (FAQ)
↓
IF intent found:
    → router → DB/service
ELSE:
    → RAG embedding search
↓
LLM format answer

👉 Đây gọi là:

Hybrid Intent + RAG architecture

và là cách chatbot production hoạt động.

💡 Tại sao không dùng embedding cho mọi thứ?

Vì embedding search:

❌ không biết hành động hệ thống
❌ không query user data
❌ không hiểu state

Ví dụ:

"job tôi apply đâu rồi?"

Embedding chỉ trả văn bản — không truy vấn DB.

## 🧠 Insight quan trọng

FAQ router =

👉 điều khiển logic app

RAG embedding =

👉 trả kiến thức văn bản

Hai thứ khác vai trò.

## 🎯 Ví dụ cực rõ
### Case 1 — hệ thống

User:

tôi có bao nhiêu hồ sơ?

→ FAQ intent

my_applications

→ DB query.

### Case 2 — kiến thức

User:

backend intern cần gì?

→ embedding search job description.

# 🚀 Bạn nên thiết kế như sau
ChatbotController
│
├─ Intent matcher (FAQ)
│     └─ router → DB/service
│
└─ fallback → RAG embedding search

👉 Đây là kiến trúc chatbot:

Slack bot

HR bot

university assistant

production AI agent

đang dùng.