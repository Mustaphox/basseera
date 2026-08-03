</main>
<footer class="footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <a class="navbar-brand mb-3 d-flex align-items-center gap-2 text-primary fs-3 fw-bold" href="<?= BASE_URL ?>">
                    <img src="<?= BASE_URL ?>logo.png" alt="بصيرة" style="height: 50px; width: auto;"> بصيرة
                </a>
                <p class="text-muted pe-lg-4">
                    <?= e(get_setting($pdo, 'site_description', 'منصة إسلامية متكاملة تضم القرآن الكريم، الأحاديث، السيرة النبوية، الأذكار، الأدعية، ومحتوى إسلاميًا موثوقًا.')) ?>
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="<?= e(get_setting($pdo, 'facebook_url', '#')) ?>" class="icon-btn bg-light-primary"><i data-lucide="facebook"></i></a>
                    <a href="<?= e(get_setting($pdo, 'twitter_url', '#')) ?>" class="icon-btn bg-light-primary"><i data-lucide="twitter"></i></a>
                    <a href="<?= e(get_setting($pdo, 'instagram_url', '#')) ?>" class="icon-btn bg-light-primary"><i data-lucide="instagram"></i></a>
                    <a href="<?= e(get_setting($pdo, 'youtube_url', '#')) ?>" class="icon-btn bg-light-primary"><i data-lucide="youtube"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <h5 class="mb-4">روابط سريعة</h5>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="<?= BASE_URL ?>quran" class="text-muted text-decoration-none">القرآن الكريم</a></li>
                    <li><a href="<?= BASE_URL ?>hadith" class="text-muted text-decoration-none">الأحاديث النبوية</a></li>
                    <li><a href="<?= BASE_URL ?>seerah" class="text-muted text-decoration-none">السيرة النبوية</a></li>
                    <li><a href="<?= BASE_URL ?>azkar" class="text-muted text-decoration-none">الأذكار</a></li>
                </ul>
            </div>
            
            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h5 class="mb-4">خدمات إسلامية</h5>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="<?= BASE_URL ?>prayer-times" class="text-muted text-decoration-none">مواقيت الصلاة</a></li>
                    <li><a href="<?= BASE_URL ?>qibla" class="text-muted text-decoration-none">اتجاه القبلة</a></li>
                    <li><a href="<?= BASE_URL ?>hijri" class="text-muted text-decoration-none">التقويم الهجري</a></li>
                    <li><a href="<?= BASE_URL ?>asma-allah" class="text-muted text-decoration-none">أسماء الله الحسنى</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <h5 class="mb-4">النشرة البريدية</h5>
                <p class="text-muted">اشترك للحصول على رسائل يومية بآيات وأحاديث وأدعية.</p>
                <form class="d-flex gap-2" onsubmit="event.preventDefault();">
                    <input type="email" class="form-control" placeholder="البريد الإلكتروني" required>
                    <button type="submit" class="btn btn-primary px-4">اشتراك</button>
                </form>
            </div>
        </div>
        
        <div class="row mt-5 pt-4 border-top">
            <div class="col-12 text-center text-muted">
                <p class="mb-1">
                    &copy; <?= date('Y') ?> <?= e(get_setting($pdo, 'site_name', 'بصيرة')) ?>. جميع الحقوق محفوظة.
                </p>
                <p class="mb-0 small">
                    تطوير:
                    <a href="https://wa.me/213665309431" target="_blank" rel="noopener noreferrer"
                       class="text-decoration-none fw-bold"
                       style="color: #FF8A00;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="#25D366" style="vertical-align:middle; margin-left:4px;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        mustoxdev
                    </a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>

</body>
</html>
