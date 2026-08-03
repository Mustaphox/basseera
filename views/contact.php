<?php $page_title = 'تواصل معنا'; ?>

<section class="py-5 bg-light-primary border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-primary mb-3">تواصل معنا</h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            نحن هنا للإجابة على استفساراتك وتلقي اقتراحاتك
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <h3 class="fw-bold mb-4">أرسل لنا رسالة</h3>
                    <form onsubmit="event.preventDefault(); alert('تم إرسال رسالتك بنجاح!');">
                        <div class="mb-3">
                            <label class="form-label text-muted">الاسم الكريم</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">البريد الإلكتروني</label>
                            <input type="email" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">الموضوع</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted">نص الرسالة</label>
                            <textarea class="form-control bg-light border-0" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">إرسال الرسالة</button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Info & FAQ -->
            <div class="col-lg-6" data-aos="fade-right">
                
                <!-- Contact Info -->
                <div class="d-flex flex-column gap-4 mb-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-btn bg-light-primary text-primary" style="cursor:default;">
                            <i data-lucide="mail"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">البريد الإلكتروني</h5>
                            <p class="text-muted mb-0" dir="ltr"><?= e(get_setting($pdo, 'contact_email', 'info@basseera.com')) ?></p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordion -->
                <h3 class="fw-bold mb-4">الأسئلة الشائعة</h3>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                هل المحتوى في المنصة موثوق؟
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary bg-white">
                                نعم، نحن نحرص على جلب المحتوى من مصادر موثوقة ككتب الصحاح، وتفاسير القرآن المعتمدة، وواجهات برمجية إسلامية مدققة.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                كيف أستخدم مسبحة الأذكار؟
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary bg-white">
                                يمكنك الدخول إلى صفحة "الأذكار"، واختيار القسم المناسب، ثم الضغط على زر العداد بجانب كل ذكر حتى يكتمل العدد المطلوب.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Map Placeholder -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-4">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d118933.26620585642!2d39.75470215758253!3d21.422509539358253!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15c21b4ced818775%3A0x98ab2469cf70c9ce!2sMecca%20Saudi%20Arabia!5e0!3m2!1sen!2s!4v1690000000000!5m2!1sen!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>

            </div>
        </div>
        
    </div>
</section>
