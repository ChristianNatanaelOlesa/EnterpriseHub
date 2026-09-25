@if (session('success'))
    <div class="eh-alert-toast eh-alert-toast-success" role="alert">

        <div class="eh-alert-toast-content">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>


        <button type="button" class="eh-alert-toast-close" onclick="this.closest('.eh-alert-toast').remove()"
            aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

    </div>
@endif


@if (session('error'))
    <div class="eh-alert-toast eh-alert-toast-error" role="alert">

        <div class="eh-alert-toast-content">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>


        <button type="button" class="eh-alert-toast-close" onclick="this.closest('.eh-alert-toast').remove()"
            aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

    </div>
@endif


@once

    @push('styles')
        <style>
            /* =========================================================
                               ENTERPRISEHUB TOAST
                            ========================================================= */

            .eh-alert-toast {

                position: fixed;

                top: 72px;

                right: 24px;

                z-index: 9999;

                width: min(420px,
                        calc(100vw - 48px));

                min-height: 54px;

                display: flex;

                align-items: center;

                justify-content: space-between;

                gap: 1rem;

                padding: .8rem 1rem;

                border-radius: 8px;

                box-shadow:
                    0 8px 24px rgba(15,
                        23,
                        42,
                        .15);

                animation:
                    ehAlertToastIn .2s ease-out;

            }


            /* =========================================================
                               CONTENT
                            ========================================================= */

            .eh-alert-toast-content {

                display: flex;

                align-items: center;

                gap: .65rem;

                font-size: .9rem;

                line-height: 1.4;

            }


            .eh-alert-toast-content i {

                font-size: 1rem;

                flex-shrink: 0;

            }


            /* =========================================================
                               SUCCESS
                            ========================================================= */

            .eh-alert-toast-success {

                background: #d1e7dd !important;

                border: 1px solid #a3cfbb !important;

                color: #0f5132 !important;

            }


            .eh-alert-toast-success .eh-alert-toast-content i {

                color: #198754;

            }


            /* =========================================================
                               ERROR
                            ========================================================= */

            .eh-alert-toast-error {

                background: #f8d7da !important;

                border: 1px solid #f1aeb5 !important;

                color: #842029 !important;

            }


            .eh-alert-toast-error .eh-alert-toast-content i {

                color: #dc3545;

            }


            /* =========================================================
                               CLOSE BUTTON
                            ========================================================= */

            .eh-alert-toast-close {

                flex-shrink: 0;

                width: 28px;

                height: 28px;

                display: inline-flex;

                align-items: center;

                justify-content: center;

                padding: 0;

                border: 0;

                background: transparent;

                color: currentColor;

                opacity: .65;

                border-radius: 6px;

                cursor: pointer;

            }


            .eh-alert-toast-close:hover {

                opacity: 1;

                background: rgba(0,
                        0,
                        0,
                        .06);

            }


            .eh-alert-toast-close i {

                font-size: .75rem;

            }


            /* =========================================================
                               ANIMATION
                            ========================================================= */

            @keyframes ehAlertToastIn {

                from {

                    opacity: 0;

                    transform:
                        translateX(20px);

                }

                to {

                    opacity: 1;

                    transform:
                        translateX(0);

                }

            }


            /* =========================================================
                               MOBILE
                            ========================================================= */

            @media (max-width: 575.98px) {

                .eh-alert-toast {

                    top: 68px;

                    right: 12px;

                    width: calc(100vw - 24px);

                }

            }
        </style>
    @endpush


    @push('scripts')
        <script>
            document.addEventListener(
                'DOMContentLoaded',
                function() {

                    const toasts =
                        document.querySelectorAll(
                            '.eh-alert-toast'
                        );


                    toasts.forEach(
                        function(toast) {

                            setTimeout(
                                function() {

                                    if (
                                        !toast.isConnected
                                    ) {
                                        return;
                                    }


                                    toast.style.opacity =
                                        '0';

                                    toast.style.transform =
                                        'translateX(20px)';


                                    toast.style.transition =
                                        'opacity .18s ease, transform .18s ease';


                                    setTimeout(
                                        function() {

                                            toast.remove();

                                        },
                                        180
                                    );

                                },
                                4500
                            );

                        }
                    );

                }
            );
        </script>
    @endpush

@endonce
