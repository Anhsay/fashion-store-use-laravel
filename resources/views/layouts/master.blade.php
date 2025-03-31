<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion Store')</title>
    <!-- Load CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Thêm style cho các nút auth */
        .auth-btn {
            transition: all 0.3s ease;
        }
        .login-btn {
            border: 1px solid #dee2e6;
        }
        .login-btn:hover {
            background-color: #f8f9fa;
        }
        .register-btn {
            background-color: #0d6efd;
            color: white;
        }
        .register-btn:hover {
            background-color: #0b5ed7;
            color: white;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
        }
        .logout-btn:hover {
            background-color: #bb2d3b;
            color: white;
        }
        .nav-user-dropdown {
            min-width: 200px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">Fashion Store</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/products">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contact">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/cart">Giỏ hàng</a>
                    </ul>
                    <!-- Phần đăng nhập/đăng ký -->
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <!-- Hiển thị khi đã đăng nhập -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end nav-user-dropdown" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i> Hồ sơ</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <!-- Hiển thị khi chưa đăng nhập -->
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn auth-btn login-btn me-2">
                                    <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn auth-btn register-btn">
                                    <i class="fas fa-user-plus me-1"></i> Đăng ký
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-4 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: support@fashionstore.com</p>
                    <p>Điện thoại: 0123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="/">Trang chủ</a></li>
                        <li><a href="/products">Sản phẩm</a></li>
                        <li><a href="/contact">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Theo dõi chúng tôi</h5>
                    <a href="#" class="btn btn-outline-dark me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-dark me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-dark me-2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <hr>
            <p>&copy; 2025 Fashion Store. All rights reserved.</p>
        </div>
    </footer>

    <!-- Load JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>