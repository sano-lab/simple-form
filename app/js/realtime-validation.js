class RealtimeValidationModel {

    /**
     * バリデーションモデルコンストラクタ
     * @param {Array} attrs - バリデーションパターン (オプション)
     */
    constructor(attrs) {
        this.val = '';
        // バリデーションパターン
        this.attrs = {
            required: attrs.required || false,  // 必須 true or (false)
            maxlength: attrs.maxlength || 8,    // 最大文字数 (8)
            minlength: attrs.minlength || 4     // 最小文字数 (4)
        };
        // オブサーバ
        this.listeners = {
            valid: [],  // バリデーション正常時
            invalid: [] // バリデーションエラー時
        };
    }

    /**
     * 入力チェック (文字比較)
     * @param {string} val - 入力チェックする文字列
     */
    set(val) {
        if (this.val === val)
            return;

        this.val = val;
        this.validate();
    }

    /**
     * 入力チェックとイベントハンドル
     * バリデーション正常時に   'valid'   イベント発行
     * バリデーションエラー時に 'invalid' イベント発行
     */
    validate() {
        let val;
        this.errors = []; // バリデーションエラー保存用

        // バリデーションチェック
        for (let key in this.attrs) {
            val = this.attrs[key];
            if (val && !this[key](val)) {
                this.errors.push(key);
            }
        }

        this.trigger(!this.errors.length ? 'valid' : 'invalid');
    }

    /**
     * イベントハンドラ登録
     * @param {string} event - イベント名
     * @param {Function} func - 関数名
     */
    on(event, func) {
        this.listeners[event].push(func);
    }

    /**
     * イベント呼び出し
     * @param {string} event - イベント名
     */
    trigger(event) {
        this.listeners[event].forEach(func => {
            func();
        });
    }

    /**
     * 必須チェック
     * @param {string} event - イベント名
     */
    required() {
        return this.val !== '';
    }

    /**
     * 最大数チェック
     * @param {Number} num - 文字数
     */
    maxlength(num) {
        return num >= this.val.length;
    }

    /**
     * 最小数チェック
     * @param {Number} num - 文字数
     */
    minlength(num) {
        return num <= this.val.length;
    }

}

class RealtimeValidationView {

    /**
     * バリデーションビューコンストラクタ
     * @param {Element} el - 要素
     */
    constructor(el) {
        this.el = el;
        this.list = this.el.nextElementSibling.children;
        this.initialize();
        this.handleEvents();
    }

    /**
     * 初期化処理
     */
    initialize() {
        const obj = this.el.dataset;

        if (this.el.required) {
            obj['required'] = true;
        }

        this.model = new RealtimeValidationModel(obj);

        for (let i = 0, len = this.list.length; i < len; i++) {
            this.list[i].style.display = 'none';
        }

    }

    /**
     * イベントハンドル
     */
    handleEvents() {
        this.el.addEventListener('keyup', e => {
            this.onKeyup(e);
        });

        this.model.on('valid', () => {
            this.onValid();
        });

        this.model.on('invalid', () => {
            this.onInvalid();
        });
    }

    onKeyup(e) {
        this.model.set(e.target.value);
    }

    onValid() {
        this.el.classList.remove('error');
        for (let i = 0, len = this.list.length; i < len; i++) {
            this.list[i].style.display = 'none';
        }
    }

    onInvalid() {
        this.el.classList.add('error');
        for (let i = 0, len = this.list.length; i < len; i++) {
            this.list[i].style.display = 'none';
        }

        this.model.errors.forEach(index => {
            for (let i = 0, len = this.list.length; i < len; i++) {
                if (this.list[i].dataset.error === index) {
                    this.list[i].style.display = 'block';
                }
            }
        });
    }
}