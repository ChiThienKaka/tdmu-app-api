# Các bảng lấy dữ liệu để train
majors
faculties
school_info
job_posts
job_categories
company_reviews
# Hệ thống chatBox
database FAQ, router chatbot, và semantic matching.
# Flow hệ thống
User message
↓
Semantic match (faq + examples): không trả lời user, chỉ để hiểu user muốn làm gì
↓
Intent identified: hành động chatbot phải thực hiện (my_applications, job_search, profile_status)
↓
Router → gọi service backend: nhóm nghiệp vụ (routing logic, context management, analytics) 
gọi service nào?: case 'my_applications':
    return ApplicationService::list($userId);
↓
Database query thật
↓
Context build
↓
LLM format câu trả lời
↓
User nhận phản hồi
## sơ đồ tối giản
User hỏi
↓
FAQ intent router
↓
IF system action → query DB
ELSE → embedding search
↓
LLM trả lời
## lưu ý
question → bắt buộc
examples → nên có
answer → optional nhưng nên giữ