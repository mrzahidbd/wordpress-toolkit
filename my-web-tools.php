<?php
/**
 * Plugin Name: My Web Tools Collection
 * Plugin URI: https://yourwebsite.com/
 * Description: 16 useful web tools. Shortcodes: [qr_code_tool], [word_counter_tool], [password_gen_tool], [discount_calc_tool], [age_calc_tool], [stopwatch_tool], [tip_calc_tool], [case_converter_tool], [bmi_calc_tool], [digital_clock_tool], [click_counter_tool], [random_num_tool], [loan_calc_tool], [temp_converter_tool], [binary_text_tool], [day_calc_tool].
 * Version: 1.4
 * Author: Your Name
 * Author URI: https://yourwebsite.com/
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
// 13. Loan Calculator (NEW) - [loan_calc_tool]
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
// 14. Temperature Converter (NEW) - [temp_converter_tool]
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
// 15. Binary <-> Text Converter (NEW) - [binary_text_tool]
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
// 16. Day of the Week (NEW) - [day_calc_tool]
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
// Common Styles
// =========================================================
function mwts_load_common_styles() {
    ?>
    <style>
        .mwts-tool-wrapper { font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; margin: 20px 0; }
        .mwts-card { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e1e4e8; width: 100%; max-width: 450px; text-align: center; }
        .mwts-card h3 { margin: 0 0 15px 0; color: #2d3748; font-size: 22px; }
        .mwts-card label { display: block; font-size: 12px; font-weight: bold; margin-bottom: 5px; text-align: left; }
        .mwts-input { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #cbd5e0; border-radius: 6px; box-sizing: border-box; font-size: 16px; }
        .mwts-input:focus { border-color: #4f46e5; outline: none; box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .mwts-btn { background-color: #4f46e5; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: 600; width: 100%; transition: 0.2s; }
        .mwts-btn:hover { opacity: 0.9; }
        .mwts-btn-outline { background-color: transparent; border: 1px solid #4f46e5; color: #4f46e5; }
        .mwts-btn-outline:hover { background-color: #f3f4f6; }
        .mwts-stat-box { background: #f7fafc; padding: 10px; border-radius: 8px; flex: 1; border: 1px solid #edf2f7; }
        .mwts-stat-num { display: block; font-size: 24px; font-weight: bold; color: #4f46e5; }
        .mwts-stat-label { font-size: 12px; color: #666; }
    </style>
    <?php
}
?>