<?php
/**
 * Plugin Name: My Web Tools Collection
 * Plugin URI: https://reviewx.app/
 * Description: 25 useful web tools including QR Code, BMI, Stopwatch, Pomodoro, and more.
 * Version: 1.7
 * Author: Mrzahidbd
 * Author URI: https://reviewx.app/
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =========================================================
// 1. QR Code Generator - [qr_code_tool]
// =========================================================
function mwts_qr_code_shortcode() {
    ob_start(); 
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>QR Code Generator</h3>
            <p>Enter text or URL below.</p>
            <input type="text" id="mwts-qr-text" class="mwts-input" placeholder="https://example.com" />
            <div id="mwts-qr-code-display" style="margin: 20px auto; min-height: 150px; display: flex; justify-content: center;"></div>
            <button onclick="mwtsGenerateQR()" class="mwts-btn">Generate QR</button>
            <button onclick="mwtsDownloadQR()" id="mwts-download-btn" class="mwts-btn mwts-btn-outline" style="display:none; margin-top: 10px;">Download Image</button>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function mwtsGenerateQR() {
            const text = document.getElementById("mwts-qr-text").value;
            const container = document.getElementById("mwts-qr-code-display");
            const dlBtn = document.getElementById("mwts-download-btn");
            container.innerHTML = "";
            if(text.trim() === "") return;
            new QRCode(container, { text: text, width: 180, height: 180, colorDark : "#000000", colorLight : "#ffffff", correctLevel : QRCode.CorrectLevel.H });
            dlBtn.style.display = "inline-block";
        }
        function mwtsDownloadQR() {
            const img = document.querySelector("#mwts-qr-code-display img");
            if(img) {
                const link = document.createElement("a"); link.href = img.src; link.download = "qrcode.png";
                document.body.appendChild(link); link.click(); document.body.removeChild(link);
            }
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('qr_code_tool', 'mwts_qr_code_shortcode');

// =========================================================
// 2. Word Counter - [word_counter_tool]
// =========================================================
function mwts_word_counter_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Word & Character Counter</h3>
            <textarea id="mwts-wc-text" class="mwts-input" rows="8" placeholder="Type or paste your text here..." oninput="mwtsCountWords()"></textarea>
            <div style="display: flex; gap: 15px; margin-top: 15px; justify-content: center;">
                <div class="mwts-stat-box"><span id="mwts-wc-words" class="mwts-stat-num">0</span><span class="mwts-stat-label">Words</span></div>
                <div class="mwts-stat-box"><span id="mwts-wc-chars" class="mwts-stat-num">0</span><span class="mwts-stat-label">Characters</span></div>
            </div>
        </div>
    </div>
    <script>
        function mwtsCountWords() {
            const text = document.getElementById("mwts-wc-text").value;
            const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
            document.getElementById("mwts-wc-words").innerText = words;
            document.getElementById("mwts-wc-chars").innerText = text.length;
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('word_counter_tool', 'mwts_word_counter_shortcode');

// =========================================================
// 3. Password Generator - [password_gen_tool]
// =========================================================
function mwts_password_gen_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Strong Password Generator</h3>
            <div class="mwts-input-group">
                <input type="text" id="mwts-pg-result" class="mwts-input" readonly style="text-align: center; font-family: monospace; font-size: 18px; letter-spacing: 1px;">
            </div>
            <div style="text-align: left; margin: 15px 0;">
                <label style="display: block; margin-bottom: 5px;">Length: <span id="mwts-pg-len-val">12</span></label>
                <input type="range" id="mwts-pg-len" min="6" max="32" value="12" style="width: 100%;" oninput="document.getElementById('mwts-pg-len-val').innerText = this.value">
                <div style="margin-top: 10px;">
                    <label><input type="checkbox" id="mwts-pg-num" checked> Include Numbers</label><br>
                    <label><input type="checkbox" id="mwts-pg-sym" checked> Include Symbols</label>
                </div>
            </div>
            <button onclick="mwtsGeneratePass()" class="mwts-btn">Generate Password</button>
            <button onclick="mwtsCopyPass()" class="mwts-btn mwts-btn-outline" style="margin-top: 10px;">Copy</button>
        </div>
    </div>
    <script>
        function mwtsGeneratePass() {
            const len = document.getElementById("mwts-pg-len").value;
            const incNum = document.getElementById("mwts-pg-num").checked;
            const incSym = document.getElementById("mwts-pg-sym").checked;
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            const nums = "0123456789";
            const syms = "!@#$%^&*()_+~`|}{[]:;?><,./-=";
            let valid = chars;
            if (incNum) valid += nums; if (incSym) valid += syms;
            let pass = "";
            for (let i = 0; i < len; i++) { pass += valid.charAt(Math.floor(Math.random() * valid.length)); }
            document.getElementById("mwts-pg-result").value = pass;
        }
        function mwtsCopyPass() {
            const copyText = document.getElementById("mwts-pg-result");
            copyText.select(); document.execCommand("copy"); alert("Password Copied!");
        }
        document.addEventListener('DOMContentLoaded', mwtsGeneratePass);
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('password_gen_tool', 'mwts_password_gen_shortcode');

// =========================================================
// 4. Discount Calculator - [discount_calc_tool]
// =========================================================
function mwts_discount_calc_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Discount Calculator</h3>
            <div style="display: flex; gap: 10px;">
                <div style="flex:1;"><label>Price</label><input type="number" id="mwts-dc-price" class="mwts-input" placeholder="0.00"></div>
                <div style="flex:1;"><label>Discount %</label><input type="number" id="mwts-dc-percent" class="mwts-input" placeholder="0"></div>
            </div>
            <button onclick="mwtsCalculateDiscount()" class="mwts-btn" style="margin-top: 15px;">Calculate</button>
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                <p>You Save: <span id="mwts-dc-saved" style="font-weight: bold; color: green;">0.00</span></p>
                <p style="font-size: 18px;">Final Price: <span id="mwts-dc-final" style="font-weight: bold; color: #4f46e5;">0.00</span></p>
            </div>
        </div>
    </div>
    <script>
        function mwtsCalculateDiscount() {
            const price = parseFloat(document.getElementById("mwts-dc-price").value) || 0;
            const percent = parseFloat(document.getElementById("mwts-dc-percent").value) || 0;
            const saved = price * (percent / 100);
            const final = price - saved;
            document.getElementById("mwts-dc-saved").innerText = saved.toFixed(2);
            document.getElementById("mwts-dc-final").innerText = final.toFixed(2);
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('discount_calc_tool', 'mwts_discount_calc_shortcode');

// =========================================================
// 5. Age Calculator - [age_calc_tool]
// =========================================================
function mwts_age_calc_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Age Calculator</h3>
            <p>Select your Date of Birth</p>
            <input type="date" id="mwts-age-dob" class="mwts-input">
            <button onclick="mwtsCalculateAge()" class="mwts-btn" style="margin-top:10px;">Calculate Age</button>
            <div id="mwts-age-result" style="margin-top: 20px; font-weight: bold; color: #333; min-height: 24px;"></div>
        </div>
    </div>
    <script>
        function mwtsCalculateAge() {
            const dobVal = document.getElementById('mwts-age-dob').value;
            if(!dobVal) return;
            const dob = new Date(dobVal);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) { age--; }
            document.getElementById('mwts-age-result').innerHTML = "You are <span style='color:#4f46e5; font-size:20px;'>" + age + "</span> years old.";
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('age_calc_tool', 'mwts_age_calc_shortcode');

// =========================================================
// 6. Stopwatch - [stopwatch_tool]
// =========================================================
function mwts_stopwatch_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Stopwatch</h3>
            <div id="mwts-sw-display" style="font-size: 40px; font-family: monospace; margin: 20px 0; color: #333;">00:00:00</div>
            <div style="display:flex; gap:10px;">
                <button onclick="mwtsStartStop()" id="mwts-sw-btn" class="mwts-btn" style="background-color: #10b981;">Start</button>
                <button onclick="mwtsReset()" class="mwts-btn" style="background-color: #ef4444;">Reset</button>
            </div>
        </div>
    </div>
    <script>
        let mwtsTimer; 
        let mwtsRunning = false;
        let mwtsSeconds = 0;
        
        function mwtsStartStop() {
            const btn = document.getElementById("mwts-sw-btn");
            if(mwtsRunning) {
                clearInterval(mwtsTimer);
                btn.innerText = "Start";
                btn.style.backgroundColor = "#10b981";
            } else {
                mwtsTimer = setInterval(() => {
                    mwtsSeconds++;
                    const h = Math.floor(mwtsSeconds / 3600).toString().padStart(2,'0');
                    const m = Math.floor((mwtsSeconds % 3600) / 60).toString().padStart(2,'0');
                    const s = (mwtsSeconds % 60).toString().padStart(2,'0');
                    document.getElementById("mwts-sw-display").innerText = `${h}:${m}:${s}`;
                }, 1000);
                btn.innerText = "Pause";
                btn.style.backgroundColor = "#f59e0b";
            }
            mwtsRunning = !mwtsRunning;
        }
        
        function mwtsReset() {
            clearInterval(mwtsTimer);
            mwtsRunning = false;
            mwtsSeconds = 0;
            document.getElementById("mwts-sw-display").innerText = "00:00:00";
            const btn = document.getElementById("mwts-sw-btn");
            btn.innerText = "Start";
            btn.style.backgroundColor = "#10b981";
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('stopwatch_tool', 'mwts_stopwatch_shortcode');

// =========================================================
// 7. Tip Calculator - [tip_calc_tool]
// =========================================================
function mwts_tip_calc_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Tip Calculator</h3>
            <div style="display:flex; gap:10px;">
                <div style="flex:1;"><label>Bill Amount</label><input type="number" id="mwts-tip-bill" class="mwts-input" placeholder="100"></div>
                <div style="flex:1;"><label>Tip %</label><input type="number" id="mwts-tip-percent" class="mwts-input" placeholder="10"></div>
            </div>
            <button onclick="mwtsCalcTip()" class="mwts-btn" style="margin-top:15px;">Calculate Tip</button>
            <div style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                <p>Tip Amount: <span id="mwts-tip-amount" style="font-weight:bold; color:#10b981;">0.00</span></p>
                <p style="font-size:18px;">Total Bill: <span id="mwts-tip-total" style="font-weight:bold; color:#4f46e5;">0.00</span></p>
            </div>
        </div>
    </div>
    <script>
        function mwtsCalcTip() {
            const bill = parseFloat(document.getElementById("mwts-tip-bill").value) || 0;
            const tipP = parseFloat(document.getElementById("mwts-tip-percent").value) || 0;
            const tipAmt = bill * (tipP / 100);
            const total = bill + tipAmt;
            document.getElementById("mwts-tip-amount").innerText = tipAmt.toFixed(2);
            document.getElementById("mwts-tip-total").innerText = total.toFixed(2);
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('tip_calc_tool', 'mwts_tip_calc_shortcode');

// =========================================================
// 8. Case Converter - [case_converter_tool]
// =========================================================
function mwts_case_converter_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Case Converter</h3>
            <textarea id="mwts-case-text" class="mwts-input" rows="5" placeholder="Type text here..."></textarea>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-top:10px;">
                <button onclick="mwtsConvertCase('upper')" class="mwts-btn mwts-btn-outline">UPPER CASE</button>
                <button onclick="mwtsConvertCase('lower')" class="mwts-btn mwts-btn-outline">lower case</button>
                <button onclick="mwtsConvertCase('cap')" class="mwts-btn mwts-btn-outline">Capitalize</button>
                <button onclick="mwtsConvertCase('copy')" class="mwts-btn" style="background-color:#333;">Copy Text</button>
            </div>
        </div>
    </div>
    <script>
        function mwtsConvertCase(type) {
            const el = document.getElementById("mwts-case-text");
            let text = el.value;
            if(type === 'upper') el.value = text.toUpperCase();
            if(type === 'lower') el.value = text.toLowerCase();
            if(type === 'cap') {
                el.value = text.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            }
            if(type === 'copy') {
                el.select(); document.execCommand("copy"); alert("Text Copied!");
            }
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('case_converter_tool', 'mwts_case_converter_shortcode');

// =========================================================
// 9. BMI Calculator - [bmi_calc_tool]
// =========================================================
function mwts_bmi_calc_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>BMI Calculator</h3>
            <div style="display:flex; gap:10px;">
                <div style="flex:1;"><label>Weight (kg)</label><input type="number" id="mwts-bmi-weight" class="mwts-input" placeholder="e.g. 70"></div>
                <div style="flex:1;"><label>Height (cm)</label><input type="number" id="mwts-bmi-height" class="mwts-input" placeholder="e.g. 175"></div>
            </div>
            <button onclick="mwtsCalcBMI()" class="mwts-btn" style="margin-top:15px;">Calculate BMI</button>
            <div id="mwts-bmi-result" style="margin-top:20px; font-weight:bold; color:#333;"></div>
        </div>
    </div>
    <script>
        function mwtsCalcBMI() {
            const w = parseFloat(document.getElementById("mwts-bmi-weight").value);
            const h = parseFloat(document.getElementById("mwts-bmi-height").value);
            if(!w || !h) { alert("Please enter both weight and height"); return; }
            const bmi = w / ((h/100) * (h/100));
            let status = "";
            if(bmi < 18.5) status = "Underweight";
            else if(bmi < 25) status = "Normal";
            else if(bmi < 30) status = "Overweight";
            else status = "Obese";
            document.getElementById("mwts-bmi-result").innerHTML = "Your BMI: <span style='color:#4f46e5; font-size:24px;'>" + bmi.toFixed(1) + "</span><br><span style='font-weight:normal; color:#666;'>" + status + "</span>";
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('bmi_calc_tool', 'mwts_bmi_calc_shortcode');

// =========================================================
// 10. Digital Clock - [digital_clock_tool]
// =========================================================
function mwts_digital_clock_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Digital Clock</h3>
            <div id="mwts-clock-display" style="font-size: 48px; font-family: monospace; font-weight:bold; color:#2d3748; padding: 20px 0; background:#f7fafc; border-radius:8px;">
                --:--:--
            </div>
            <p id="mwts-date-display" style="margin-top:10px; color:#666; font-size:14px;"></p>
        </div>
    </div>
    <script>
        function mwtsUpdateClock() {
            const now = new Date();
            document.getElementById("mwts-clock-display").innerText = now.toLocaleTimeString();
            document.getElementById("mwts-date-display").innerText = now.toDateString();
        }
        setInterval(mwtsUpdateClock, 1000);
        mwtsUpdateClock();
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('digital_clock_tool', 'mwts_digital_clock_shortcode');

// =========================================================
// 11. Click Counter / Tasbeeh - [click_counter_tool]
// =========================================================
function mwts_click_counter_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Click Counter / Tasbeeh</h3>
            <div id="mwts-counter-val" style="font-size: 60px; font-weight:bold; color:#4f46e5; margin: 20px 0;">0</div>
            <button onclick="mwtsCountUp()" class="mwts-btn" style="height: 60px; font-size: 24px;">+</button>
            <div style="display:flex; gap:10px; margin-top:10px;">
                <button onclick="mwtsCountDown()" class="mwts-btn mwts-btn-outline">-</button>
                <button onclick="mwtsCountReset()" class="mwts-btn mwts-btn-outline" style="color:red; border-color:red;">Reset</button>
            </div>
        </div>
    </div>
    <script>
        let mwtsCount = 0;
        function mwtsCountUp() { mwtsCount++; document.getElementById("mwts-counter-val").innerText = mwtsCount; }
        function mwtsCountDown() { if(mwtsCount>0) mwtsCount--; document.getElementById("mwts-counter-val").innerText = mwtsCount; }
        function mwtsCountReset() { mwtsCount=0; document.getElementById("mwts-counter-val").innerText = mwtsCount; }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('click_counter_tool', 'mwts_click_counter_shortcode');

// =========================================================
// 12. Random Number Generator - [random_num_tool]
// =========================================================
function mwts_random_num_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Random Number Gen</h3>
            <div style="display:flex; gap:10px;">
                <div style="flex:1;"><label>Min</label><input type="number" id="mwts-rnd-min" class="mwts-input" value="1"></div>
                <div style="flex:1;"><label>Max</label><input type="number" id="mwts-rnd-max" class="mwts-input" value="100"></div>
            </div>
            <button onclick="mwtsGenRandom()" class="mwts-btn" style="margin-top:15px;">Generate</button>
            <div id="mwts-rnd-result" style="margin-top:20px; font-size: 40px; font-weight: bold; color: #4f46e5;">?</div>
        </div>
    </div>
    <script>
        function mwtsGenRandom() {
            const min = parseInt(document.getElementById("mwts-rnd-min").value);
            const max = parseInt(document.getElementById("mwts-rnd-max").value);
            if(min >= max) { alert("Max must be greater than Min"); return; }
            const rnd = Math.floor(Math.random() * (max - min + 1)) + min;
            document.getElementById("mwts-rnd-result").innerText = rnd;
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('random_num_tool', 'mwts_random_num_shortcode');

// =========================================================
// 13. Loan Calculator - [loan_calc_tool]
// =========================================================
function mwts_loan_calc_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Loan Calculator</h3>
            <label>Amount ($)</label><input type="number" id="mwts-ln-amt" class="mwts-input" placeholder="e.g. 10000">
            <div style="display:flex; gap:10px;">
                <div style="flex:1;"><label>Rate (%)</label><input type="number" id="mwts-ln-rate" class="mwts-input" placeholder="5"></div>
                <div style="flex:1;"><label>Months</label><input type="number" id="mwts-ln-term" class="mwts-input" placeholder="12"></div>
            </div>
            <button onclick="mwtsCalcLoan()" class="mwts-btn" style="margin-top:10px;">Calculate Payment</button>
            <div style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                <p>Monthly Pay: <span id="mwts-ln-monthly" style="font-weight:bold; color:#4f46e5;">0.00</span></p>
                <p>Total Pay: <span id="mwts-ln-total" style="font-weight:bold; color:#333;">0.00</span></p>
            </div>
        </div>
    </div>
    <script>
        function mwtsCalcLoan() {
            const p = parseFloat(document.getElementById("mwts-ln-amt").value);
            const r = parseFloat(document.getElementById("mwts-ln-rate").value) / 100 / 12;
            const n = parseFloat(document.getElementById("mwts-ln-term").value);
            if(!p || !n) return;
            const x = Math.pow(1 + r, n);
            const monthly = (p * x * r) / (x - 1);
            const total = monthly * n;
            document.getElementById("mwts-ln-monthly").innerText = monthly.toFixed(2);
            document.getElementById("mwts-ln-total").innerText = total.toFixed(2);
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('loan_calc_tool', 'mwts_loan_calc_shortcode');

// =========================================================
// 14. Temperature Converter - [temp_converter_tool]
// =========================================================
function mwts_temp_converter_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Temperature Converter</h3>
            <div style="display:flex; gap:10px; align-items:center;">
                <div style="flex:1;">
                    <label>Celsius</label>
                    <input type="number" id="mwts-temp-c" class="mwts-input" oninput="mwtsConvTemp('C')">
                </div>
                <div style="font-weight:bold; padding-top:15px;">=</div>
                <div style="flex:1;">
                    <label>Fahrenheit</label>
                    <input type="number" id="mwts-temp-f" class="mwts-input" oninput="mwtsConvTemp('F')">
                </div>
            </div>
        </div>
    </div>
    <script>
        function mwtsConvTemp(type) {
            const cEl = document.getElementById("mwts-temp-c");
            const fEl = document.getElementById("mwts-temp-f");
            if(type === 'C') {
                const c = parseFloat(cEl.value);
                if(isNaN(c)) { fEl.value = ''; return; }
                fEl.value = ((c * 9/5) + 32).toFixed(2);
            } else {
                const f = parseFloat(fEl.value);
                if(isNaN(f)) { cEl.value = ''; return; }
                cEl.value = ((f - 32) * 5/9).toFixed(2);
            }
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('temp_converter_tool', 'mwts_temp_converter_shortcode');

// =========================================================
// 15. Binary <-> Text Converter - [binary_text_tool]
// =========================================================
function mwts_binary_text_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Binary <-> Text</h3>
            <textarea id="mwts-bt-input" class="mwts-input" rows="4" placeholder="Input..."></textarea>
            <div style="display:flex; gap:10px; margin-top:10px;">
                <button onclick="mwtsToBinary()" class="mwts-btn">Text to Binary</button>
                <button onclick="mwtsToText()" class="mwts-btn mwts-btn-outline">Binary to Text</button>
            </div>
            <textarea id="mwts-bt-output" class="mwts-input" rows="4" style="margin-top:15px; background:#f9f9f9;" readonly placeholder="Result..."></textarea>
        </div>
    </div>
    <script>
        function mwtsToBinary() {
            const input = document.getElementById("mwts-bt-input").value;
            let output = "";
            for (let i = 0; i < input.length; i++) {
                output += input[i].charCodeAt(0).toString(2).padStart(8, '0') + " ";
            }
            document.getElementById("mwts-bt-output").value = output.trim();
        }
        function mwtsToText() {
            const input = document.getElementById("mwts-bt-input").value.trim().split(" ");
            let output = "";
            for (let i = 0; i < input.length; i++) {
                output += String.fromCharCode(parseInt(input[i], 2));
            }
            document.getElementById("mwts-bt-output").value = output;
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('binary_text_tool', 'mwts_binary_text_shortcode');

// =========================================================
// 16. Day of the Week - [day_calc_tool]
// =========================================================
function mwts_day_calc_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Day of the Week</h3>
            <p>Enter a date to find the day</p>
            <input type="date" id="mwts-day-date" class="mwts-input">
            <button onclick="mwtsFindDay()" class="mwts-btn" style="margin-top:10px;">Find Day</button>
            <div id="mwts-day-result" style="margin-top:20px; font-size:24px; font-weight:bold; color:#4f46e5;"></div>
        </div>
    </div>
    <script>
        function mwtsFindDay() {
            const dateVal = document.getElementById("mwts-day-date").value;
            if(!dateVal) return;
            const date = new Date(dateVal);
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            document.getElementById("mwts-day-result").innerText = days[date.getDay()];
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('day_calc_tool', 'mwts_day_calc_shortcode');

// =========================================================
// 17. Aspect Ratio Calculator - [aspect_ratio_tool]
// =========================================================
function mwts_aspect_ratio_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Aspect Ratio Calculator</h3>
            <div style="display:flex; gap:10px;">
                <div style="flex:1;"><label>Width</label><input type="number" id="mwts-ar-w" class="mwts-input" placeholder="1920"></div>
                <div style="flex:1;"><label>Height</label><input type="number" id="mwts-ar-h" class="mwts-input" placeholder="1080"></div>
            </div>
            <button onclick="mwtsCalcRatio()" class="mwts-btn" style="margin-top:10px;">Find Ratio</button>
            <div id="mwts-ar-result" style="margin-top:20px; font-size:24px; font-weight:bold; color:#4f46e5;"></div>
        </div>
    </div>
    <script>
        function mwtsGcd(a, b) { return b == 0 ? a : mwtsGcd(b, a % b); }
        function mwtsCalcRatio() {
            const w = parseInt(document.getElementById("mwts-ar-w").value);
            const h = parseInt(document.getElementById("mwts-ar-h").value);
            if(!w || !h) return;
            const r = mwtsGcd(w, h);
            document.getElementById("mwts-ar-result").innerText = (w/r) + ":" + (h/r);
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('aspect_ratio_tool', 'mwts_aspect_ratio_shortcode');

// =========================================================
// 18. Hex to RGB Converter - [hex_rgb_tool]
// =========================================================
function mwts_hex_rgb_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Hex to RGB Converter</h3>
            <label>Hex Code</label>
            <input type="text" id="mwts-hex-in" class="mwts-input" placeholder="#FFFFFF">
            <button onclick="mwtsHexToRgb()" class="mwts-btn" style="margin-top:10px;">Convert</button>
            <div id="mwts-hex-result" style="margin-top:20px; font-size:20px; font-weight:bold; color:#333;"></div>
        </div>
    </div>
    <script>
        function mwtsHexToRgb() {
            let hex = document.getElementById("mwts-hex-in").value.replace('#','');
            if(hex.length === 3) hex = hex.split('').map(c=>c+c).join('');
            if(hex.length !== 6) { document.getElementById("mwts-hex-result").innerText = "Invalid Hex"; return; }
            const r = parseInt(hex.substring(0,2), 16);
            const g = parseInt(hex.substring(2,4), 16);
            const b = parseInt(hex.substring(4,6), 16);
            document.getElementById("mwts-hex-result").innerText = `rgb(${r}, ${g}, ${b})`;
            document.getElementById("mwts-hex-result").style.color = `rgb(${r}, ${g}, ${b})`;
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('hex_rgb_tool', 'mwts_hex_rgb_shortcode');

// =========================================================
// 19. Roman Numeral Converter - [roman_num_tool]
// =========================================================
function mwts_roman_num_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Roman Numeral Converter</h3>
            <label>Enter Number</label>
            <input type="number" id="mwts-roman-in" class="mwts-input" placeholder="e.g. 2024">
            <button onclick="mwtsToRoman()" class="mwts-btn" style="margin-top:10px;">Convert</button>
            <div id="mwts-roman-result" style="margin-top:20px; font-size:24px; font-weight:bold; color:#4f46e5;"></div>
        </div>
    </div>
    <script>
        function mwtsToRoman() {
            let num = parseInt(document.getElementById("mwts-roman-in").value);
            if(!num || num < 1 || num > 3999) { document.getElementById("mwts-roman-result").innerText = "Enter 1-3999"; return; }
            const lookup = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1};
            let roman = '';
            for(let i in lookup) {
                while(num >= lookup[i]) { roman += i; num -= lookup[i]; }
            }
            document.getElementById("mwts-roman-result").innerText = roman;
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('roman_num_tool', 'mwts_roman_num_shortcode');

// =========================================================
// 20. Palindrome Checker - [palindrome_tool]
// =========================================================
function mwts_palindrome_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Palindrome Checker</h3>
            <p>Check if text reads the same backward</p>
            <input type="text" id="mwts-pal-in" class="mwts-input" placeholder="e.g. madam">
            <button onclick="mwtsCheckPal()" class="mwts-btn" style="margin-top:10px;">Check</button>
            <div id="mwts-pal-result" style="margin-top:20px; font-weight:bold;"></div>
        </div>
    </div>
    <script>
        function mwtsCheckPal() {
            const str = document.getElementById("mwts-pal-in").value.toLowerCase().replace(/[^a-z0-9]/g, '');
            if(!str) return;
            const rev = str.split('').reverse().join('');
            const res = document.getElementById("mwts-pal-result");
            if(str === rev) {
                res.innerText = "Yes! It is a Palindrome.";
                res.style.color = "green";
            } else {
                res.innerText = "No, it's not.";
                res.style.color = "red";
            }
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('palindrome_tool', 'mwts_palindrome_shortcode');

// =========================================================
// 21. Text Reverser (NEW) - [text_reverser_tool]
// =========================================================
function mwts_text_reverser_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Text Reverser</h3>
            <input type="text" id="mwts-rev-in" class="mwts-input" placeholder="Type something..." oninput="mwtsReverseText()">
            <div id="mwts-rev-res" style="margin-top:20px; font-size:20px; font-weight:bold; color:#4f46e5; word-wrap:break-word;"></div>
        </div>
    </div>
    <script>
        function mwtsReverseText() {
            const str = document.getElementById("mwts-rev-in").value;
            document.getElementById("mwts-rev-res").innerText = str.split('').reverse().join('');
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('text_reverser_tool', 'mwts_text_reverser_shortcode');

// =========================================================
// 22. Vowel Counter (NEW) - [vowel_counter_tool]
// =========================================================
function mwts_vowel_counter_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Vowel Counter</h3>
            <textarea id="mwts-vow-in" class="mwts-input" rows="4" placeholder="Type text here..." oninput="mwtsCountVowels()"></textarea>
            <div id="mwts-vow-res" style="margin-top:20px; font-size:24px; font-weight:bold; color:#10b981;">0 Vowels</div>
        </div>
    </div>
    <script>
        function mwtsCountVowels() {
            const str = document.getElementById("mwts-vow-in").value;
            const count = (str.match(/[aeiou]/gi) || []).length;
            document.getElementById("mwts-vow-res").innerText = count + " Vowels";
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('vowel_counter_tool', 'mwts_vowel_counter_shortcode');

// =========================================================
// 23. Pomodoro Timer (NEW) - [pomodoro_tool]
// =========================================================
function mwts_pomodoro_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Pomodoro Timer</h3>
            <div id="mwts-pomo-display" style="font-size: 50px; font-family: monospace; font-weight:bold; color:#2d3748; margin:20px 0;">25:00</div>
            <button onclick="mwtsStartPomo()" id="mwts-pomo-btn" class="mwts-btn" style="background-color:#e11d48;">Start Focus</button>
            <button onclick="mwtsResetPomo()" class="mwts-btn mwts-btn-outline" style="margin-top:10px;">Reset</button>
        </div>
    </div>
    <script>
        let pomoTimer;
        let pomoTime = 25 * 60;
        let pomoRunning = false;

        function mwtsUpdatePomoDisplay() {
            const m = Math.floor(pomoTime / 60).toString().padStart(2,'0');
            const s = (pomoTime % 60).toString().padStart(2,'0');
            document.getElementById("mwts-pomo-display").innerText = `${m}:${s}`;
        }

        function mwtsStartPomo() {
            const btn = document.getElementById("mwts-pomo-btn");
            if(pomoRunning) {
                clearInterval(pomoTimer);
                btn.innerText = "Resume Focus";
                pomoRunning = false;
            } else {
                pomoTimer = setInterval(() => {
                    if(pomoTime > 0) {
                        pomoTime--;
                        mwtsUpdatePomoDisplay();
                    } else {
                        clearInterval(pomoTimer);
                        alert("Time's up! Take a break.");
                        mwtsResetPomo();
                    }
                }, 1000);
                btn.innerText = "Pause";
                pomoRunning = true;
            }
        }

        function mwtsResetPomo() {
            clearInterval(pomoTimer);
            pomoTime = 25 * 60;
            pomoRunning = false;
            mwtsUpdatePomoDisplay();
            document.getElementById("mwts-pomo-btn").innerText = "Start Focus";
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('pomodoro_tool', 'mwts_pomodoro_shortcode');

// =========================================================
// 24. Gradient Generator (NEW) - [gradient_gen_tool]
// =========================================================
function mwts_gradient_gen_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Gradient Generator</h3>
            <div id="mwts-grad-preview" style="height:100px; width:100%; border-radius:8px; margin-bottom:15px; background: linear-gradient(to right, #4f46e5, #ec4899);"></div>
            <div style="display:flex; gap:10px;">
                <input type="color" id="mwts-grad-c1" value="#4f46e5" style="width:100%; height:40px; cursor:pointer;" oninput="mwtsUpdateGrad()">
                <input type="color" id="mwts-grad-c2" value="#ec4899" style="width:100%; height:40px; cursor:pointer;" oninput="mwtsUpdateGrad()">
            </div>
            <textarea id="mwts-grad-code" class="mwts-input" rows="2" style="margin-top:15px; font-size:12px;" readonly>background: linear-gradient(to right, #4f46e5, #ec4899);</textarea>
        </div>
    </div>
    <script>
        function mwtsUpdateGrad() {
            const c1 = document.getElementById("mwts-grad-c1").value;
            const c2 = document.getElementById("mwts-grad-c2").value;
            const code = `background: linear-gradient(to right, ${c1}, ${c2});`;
            document.getElementById("mwts-grad-preview").style = code;
            document.getElementById("mwts-grad-code").value = code;
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('gradient_gen_tool', 'mwts_gradient_gen_shortcode');

// =========================================================
// 25. Password Strength Checker (NEW) - [pass_strength_tool]
// =========================================================
function mwts_pass_strength_shortcode() {
    ob_start();
    ?>
    <div class="mwts-tool-wrapper">
        <div class="mwts-card">
            <h3>Password Strength</h3>
            <input type="password" id="mwts-ps-in" class="mwts-input" placeholder="Type password..." oninput="mwtsCheckStrength()">
            <div id="mwts-ps-bar" style="height:5px; width:0%; background:red; transition:0.3s; margin-top:5px; border-radius:3px;"></div>
            <p id="mwts-ps-text" style="margin-top:10px; font-weight:bold; color:gray;">Enter password</p>
        </div>
    </div>
    <script>
        function mwtsCheckStrength() {
            const p = document.getElementById("mwts-ps-in").value;
            const bar = document.getElementById("mwts-ps-bar");
            const txt = document.getElementById("mwts-ps-text");
            let score = 0;
            if(p.length > 5) score++;
            if(p.length > 10) score++;
            if(/[A-Z]/.test(p)) score++;
            if(/[0-9]/.test(p)) score++;
            if(/[^A-Za-z0-9]/.test(p)) score++;

            if(p.length === 0) { bar.style.width="0%"; txt.innerText=""; return; }

            const colors = ["red", "orange", "yellow", "blue", "green"];
            const labels = ["Very Weak", "Weak", "Medium", "Strong", "Very Strong"];
            
            let idx = score - 1;
            if(idx < 0) idx = 0;
            
            bar.style.width = ((idx+1)*20) + "%";
            bar.style.background = colors[idx];
            txt.innerText = labels[idx];
            txt.style.color = colors[idx];
        }
    </script>
    <?php
    mwts_load_common_styles();
    return ob_get_clean();
}
add_shortcode('pass_strength_tool', 'mwts_pass_strength_shortcode');


// =========================================================
// Common Styles (Updated for better UI)
// =========================================================
function mwts_load_common_styles() {
    ?>
    <style>
        .mwts-tool-wrapper { font-family: 'Segoe UI', Tahoma, sans-serif; display: flex; justify-content: center; margin: 30px 0; }
        .mwts-card { 
            background: #ffffff; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
            border: 1px solid #f0f0f0; 
            width: 100%; 
            max-width: 450px; 
            text-align: center; 
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .mwts-card:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
        .mwts-card h3 { margin: 0 0 20px 0; color: #1f2937; font-size: 24px; font-weight: 700; }
        .mwts-card label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; text-align: left; color: #4b5563; }
        .mwts-input { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 12px; 
            border: 2px solid #e5e7eb; 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 16px; 
            transition: border-color 0.2s;
        }
        .mwts-input:focus { border-color: #4f46e5; outline: none; }
        .mwts-btn { 
            background-color: #4f46e5; 
            color: white; 
            border: none; 
            padding: 12px 20px; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: 600; 
            width: 100%; 
            transition: background-color 0.2s; 
        }
        .mwts-btn:hover { background-color: #4338ca; }
        .mwts-btn-outline { background-color: transparent; border: 2px solid #4f46e5; color: #4f46e5; }
        .mwts-btn-outline:hover { background-color: #eff6ff; }
        .mwts-stat-box { background: #f3f4f6; padding: 15px; border-radius: 8px; flex: 1; }
        .mwts-stat-num { display: block; font-size: 28px; font-weight: bold; color: #4f46e5; }
        .mwts-stat-label { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
    <?php
}
?>
