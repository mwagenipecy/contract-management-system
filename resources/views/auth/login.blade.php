<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Management System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .gradient-bg {
            /* PLACE YOUR BACKGROUND IMAGE HERE */
            background-image: 
                url('/airport.webp'); /* <- ADD YOUR IMAGE URL HERE */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            overflow: hidden;
        }
        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(30, 64, 175, 0.2) 0%, transparent 50%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .slide-in {
            animation: slideIn 0.8s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4" x-data="{ showPassword: false, isLoading: false }">
    
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Floating Circles -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white opacity-5 rounded-full floating-animation"></div>
        <div class="absolute top-3/4 right-1/4 w-32 h-32 bg-blue-200 opacity-10 rounded-full floating-animation" style="animation-delay: -2s;"></div>
        <div class="absolute top-1/2 right-1/3 w-48 h-48 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -4s;"></div>
        
        <!-- Geometric Shapes -->
        <div class="absolute top-10 right-10 w-20 h-20 border-2 border-white border-opacity-20 rotate-45 floating-animation"></div>
        <div class="absolute bottom-20 left-10 w-16 h-16 border-2 border-blue-200 border-opacity-30 rounded-full floating-animation" style="animation-delay: -3s;"></div>
    </div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-md slide-in">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center  bg-opacity-20 backdrop-filter backdrop-blur-lg  mb-4 ">
               

                <img class=" h-16 text-white"  src="{{ asset('/logoV1.png') }}" /> 

            </div>
            <h1 class="text-3xl font-bold text-[#DE0D74] mb-2"> Memoirex </h1>
            <p class="text-white text-opacity-80">Sign in to your Memoirex System</p>
        </div>


        <x-validation-errors class="mb-4" />


        <!-- Login Form -->
        <div class="glass-effect rounded-3xl p-8 shadow-2xl">
            <form method="post" action="{{ route('login') }}" class="space-y-6" >
                @csrf
                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-white">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-white text-opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            required
                            class="block w-full pl-10 pr-3 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-xl text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 focus:border-transparent transition-all duration-200"
                            placeholder="Enter your email"
                            autocomplete="email">
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-white">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-white text-opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password"
                            required
                            class="block w-full pl-10 pr-12 py-3 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-xl text-white placeholder-white placeholder-opacity-60 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 focus:border-transparent transition-all duration-200"
                            placeholder="Enter your password"
                            autocomplete="current-password">
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-white text-opacity-60 hover:text-opacity-100 transition-colors duration-200">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember-me" 
                            name="remember-me" 
                            type="checkbox" 
                            class="h-4 w-4 text-white bg-white bg-opacity-20 border-white border-opacity-30 rounded focus:ring-white focus:ring-opacity-50 focus:ring-2">
                        <label for="remember-me" class="ml-2 block text-sm text-white text-opacity-80">
                            Remember me
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="text-[#DE0D74] text-opacity-80 hover:text-opacity-100 transition-colors duration-200">
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-[#DE0D74] bg-white hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white focus:ring-opacity-50 transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!isLoading" class="flex items-center">
                            <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Sign in to Dashboard
                        </span>
                        <span x-show="isLoading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </button>
                </div>
            </form>

            <!-- Divider -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white border-opacity-30"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        
                    </div>
                </div>
            </div>

            <!-- Sign Up Link -->
            <div class="mt-6 text-center">
               
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-[#022E64]  text-sm">
                © 2025 Contract Management System. All rights reserved.
            </p>
            <div class="flex justify-center space-x-6 mt-4">
                <a href="#" class="text-[#022E64]  hover:text-opacity-80 text-sm transition-colors duration-200">Privacy Policy</a>
                <a href="#" class="text-[#022E64]  hover:text-opacity-80 text-sm transition-colors duration-200">Terms of Service</a>
                <a href="#" class="text-[#022E64]  hover:text-opacity-80 text-sm transition-colors duration-200">Support</a>
            </div>
        </div>
    </div>

   
</body>
</html>