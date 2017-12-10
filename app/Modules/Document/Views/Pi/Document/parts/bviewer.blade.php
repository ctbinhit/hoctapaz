@push('stylesheet')
<!--<link href="{!! asset('public/plugins/TNViewer/css/theme.css') !!}" rel="stylesheet" />-->
@endpush
@push('scripts')

<!--<script src="{!! asset('public/plugins/TNViewer/build/pdf.js') !!}"></script>-->
<script>
    $(document).ready(function () {
//        if ($('.jquery-tnviewer').length > 0) {
//            var url = $('#pdf_url').val();
//            PDFJS.workerSrc = $('#pdf_worker').val();
//            var pdfDoc = null,
//                    pageNum = 1,
//                    pageRendering = false,
//                    pageNumPending = null,
//                    scale = 1.5,
//                    canvas = document.getElementById('the-canvas'),
//                    ctx = canvas.getContext('2d');
//
//            document.getElementById('prev').addEventListener('click', onPrevPage);
//            document.getElementById('next').addEventListener('click', onNextPage);
//
//            PDFJS.getDocument(url).then(function (pdfDoc_) {
//                pdfDoc = pdfDoc_;
//                document.getElementById('page_count').textContent = pdfDoc.numPages;
//                renderPage(pageNum);
//            });
//        }


        function renderPage(num) {
            pageRendering = true;
            // Using promise to fetch the page
            pdfDoc.getPage(num).then(function (page) {
                var viewport = page.getViewport(scale);
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);
                // Wait for rendering to finish
                renderTask.promise.then(function () {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
            // Update page counters
            document.getElementById('page_num').textContent = pageNum;
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }


        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }

    });
</script>
@endpush