# 🎯 دليل إدارة إعدادات التحميل من Flutter Admin Panel

## 📋 ملخص النظام

تم تطوير نظام إدارة متقدم لإعدادات التحميل يمكن الآدمن من تحديث جميع الإعدادات من لوحة الإدارة في Flutter دون الحاجة لتعديل ملفات الخادم.

## 🔗 API Endpoints للإدارة

### 1. جلب جميع الإعدادات
```
GET /api/admin/download-settings/
```

**Headers المطلوبة:**
```json
{
  "Authorization": "Bearer {admin_token}",
  "Content-Type": "application/json"
}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "key": "default_max_downloads",
      "value": 3,
      "type": "integer",
      "description": "Default number of downloads per token",
      "updated_at": "2025-11-05 12:00:00"
    },
    {
      "id": 2,
      "key": "max_downloads",
      "value": 10,
      "type": "integer",
      "description": "Maximum allowed downloads per token",
      "updated_at": "2025-11-05 12:00:00"
    }
  ],
  "message": "Download settings retrieved successfully"
}
```

### 2. تحديث الإعدادات
```
POST /api/admin/download-settings/update
```

**Request Body:**
```json
{
  "settings": [
    {
      "key": "default_max_downloads",
      "value": 5
    },
    {
      "key": "max_downloads",
      "value": 15
    },
    {
      "key": "send_download_email",
      "value": true
    }
  ]
}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "key": "default_max_downloads",
      "value": 5,
      "type": "integer"
    }
  ],
  "message": "Download settings updated successfully"
}
```

### 3. جلب إعداد محدد
```
GET /api/admin/download-settings/{key}
```

**مثال:**
```
GET /api/admin/download-settings/default_max_downloads
```

### 4. إعادة تعيين الإعدادات للقيم الافتراضية
```
POST /api/admin/download-settings/reset
```

## 📱 Flutter Implementation Example

### 1. Download Settings Model
```dart
class DownloadSetting {
  final int id;
  final String key;
  final dynamic value;
  final String type;
  final String description;
  final DateTime updatedAt;

  DownloadSetting({
    required this.id,
    required this.key,
    required this.value,
    required this.type,
    required this.description,
    required this.updatedAt,
  });

  factory DownloadSetting.fromJson(Map<String, dynamic> json) {
    return DownloadSetting(
      id: json['id'],
      key: json['key'],
      value: json['value'],
      type: json['type'],
      description: json['description'],
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'key': key,
      'value': value,
    };
  }
}
```

### 2. API Service Class
```dart
class DownloadSettingsService {
  final String baseUrl = 'https://your-domain.com/api/admin/download-settings';
  final String token; // Admin token

  DownloadSettingsService(this.token);

  Map<String, String> get headers => {
    'Authorization': 'Bearer $token',
    'Content-Type': 'application/json',
  };

  // جلب جميع الإعدادات
  Future<List<DownloadSetting>> getAllSettings() async {
    final response = await http.get(
      Uri.parse(baseUrl),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      if (data['success']) {
        return (data['data'] as List)
            .map((json) => DownloadSetting.fromJson(json))
            .toList();
      }
    }
    throw Exception('Failed to load settings');
  }

  // تحديث الإعدادات
  Future<bool> updateSettings(List<DownloadSetting> settings) async {
    final response = await http.post(
      Uri.parse('$baseUrl/update'),
      headers: headers,
      body: json.encode({
        'settings': settings.map((s) => s.toJson()).toList(),
      }),
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return data['success'] ?? false;
    }
    return false;
  }

  // إعادة تعيين للقيم الافتراضية
  Future<bool> resetToDefaults() async {
    final response = await http.post(
      Uri.parse('$baseUrl/reset'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return data['success'] ?? false;
    }
    return false;
  }
}
```

### 3. Flutter Admin Screen
```dart
class DownloadSettingsScreen extends StatefulWidget {
  @override
  _DownloadSettingsScreenState createState() => _DownloadSettingsScreenState();
}

class _DownloadSettingsScreenState extends State<DownloadSettingsScreen> {
  final DownloadSettingsService _service = DownloadSettingsService('admin_token');
  List<DownloadSetting> settings = [];
  bool isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadSettings();
  }

  Future<void> _loadSettings() async {
    try {
      final loadedSettings = await _service.getAllSettings();
      setState(() {
        settings = loadedSettings;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        isLoading = false;
      });
      _showErrorSnackbar('خطأ في جلب الإعدادات: $e');
    }
  }

  Future<void> _updateSettings() async {
    try {
      setState(() => isLoading = true);
      final success = await _service.updateSettings(settings);
      setState(() => isLoading = false);
      
      if (success) {
        _showSuccessSnackbar('تم تحديث الإعدادات بنجاح');
      } else {
        _showErrorSnackbar('فشل في تحديث الإعدادات');
      }
    } catch (e) {
      setState(() => isLoading = false);
      _showErrorSnackbar('خطأ في التحديث: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('إعدادات التحميل'),
        actions: [
          IconButton(
            icon: Icon(Icons.refresh),
            onPressed: _loadSettings,
          ),
          IconButton(
            icon: Icon(Icons.restore),
            onPressed: _resetToDefaults,
          ),
        ],
      ),
      body: isLoading
          ? Center(child: CircularProgressIndicator())
          : ListView.builder(
              padding: EdgeInsets.all(16),
              itemCount: settings.length,
              itemBuilder: (context, index) {
                final setting = settings[index];
                return _buildSettingCard(setting, index);
              },
            ),
      floatingActionButton: FloatingActionButton(
        onPressed: _updateSettings,
        child: Icon(Icons.save),
        tooltip: 'حفظ التغييرات',
      ),
    );
  }

  Widget _buildSettingCard(DownloadSetting setting, int index) {
    return Card(
      margin: EdgeInsets.only(bottom: 16),
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              _getSettingDisplayName(setting.key),
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 8),
            Text(
              setting.description,
              style: TextStyle(color: Colors.grey[600], fontSize: 14),
            ),
            SizedBox(height: 12),
            _buildSettingInput(setting, index),
          ],
        ),
      ),
    );
  }

  Widget _buildSettingInput(DownloadSetting setting, int index) {
    switch (setting.type) {
      case 'boolean':
        return SwitchListTile(
          title: Text('مفعل'),
          value: setting.value == true || setting.value == 1,
          onChanged: (bool value) {
            setState(() {
              settings[index] = DownloadSetting(
                id: setting.id,
                key: setting.key,
                value: value,
                type: setting.type,
                description: setting.description,
                updatedAt: setting.updatedAt,
              );
            });
          },
        );
      
      case 'integer':
        return TextFormField(
          initialValue: setting.value.toString(),
          keyboardType: TextInputType.number,
          decoration: InputDecoration(
            labelText: 'القيمة',
            border: OutlineInputBorder(),
          ),
          onChanged: (String value) {
            final intValue = int.tryParse(value) ?? setting.value;
            setState(() {
              settings[index] = DownloadSetting(
                id: setting.id,
                key: setting.key,
                value: intValue,
                type: setting.type,
                description: setting.description,
                updatedAt: setting.updatedAt,
              );
            });
          },
        );
      
      default:
        return TextFormField(
          initialValue: setting.value.toString(),
          decoration: InputDecoration(
            labelText: 'القيمة',
            border: OutlineInputBorder(),
          ),
          onChanged: (String value) {
            setState(() {
              settings[index] = DownloadSetting(
                id: setting.id,
                key: setting.key,
                value: value,
                type: setting.type,
                description: setting.description,
                updatedAt: setting.updatedAt,
              );
            });
          },
        );
    }
  }

  String _getSettingDisplayName(String key) {
    final displayNames = {
      'default_max_downloads': 'العدد الافتراضي للتحميلات',
      'max_downloads': 'الحد الأقصى للتحميلات',
      'min_downloads': 'الحد الأدنى للتحميلات',
      'default_expiry_hours': 'مدة انتهاء الصلاحية (ساعات)',
      'max_expiry_hours': 'أقصى مدة انتهاء صلاحية',
      'min_expiry_hours': 'أقل مدة انتهاء صلاحية',
      'allow_unlimited': 'السماح بالتحميل غير المحدود',
      'cleanup_expired_after_days': 'تنظيف الملفات المنتهية الصلاحية (أيام)',
      'send_download_email': 'إرسال إيميل التحميل',
      'send_expiry_warning': 'إرسال تحذير انتهاء الصلاحية',
      'warning_hours_before_expiry': 'ساعات التحذير قبل انتهاء الصلاحية',
      'enable_ip_restriction': 'تفعيل قيود IP',
      'enable_user_agent_check': 'تفعيل فحص User Agent',
    };
    return displayNames[key] ?? key;
  }

  Future<void> _resetToDefaults() async {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('إعادة تعيين الإعدادات'),
        content: Text('هل أنت متأكد من إعادة تعيين جميع الإعدادات للقيم الافتراضية؟'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: Text('إلغاء'),
          ),
          ElevatedButton(
            onPressed: () async {
              Navigator.pop(context);
              try {
                setState(() => isLoading = true);
                final success = await _service.resetToDefaults();
                if (success) {
                  await _loadSettings();
                  _showSuccessSnackbar('تم إعادة تعيين الإعدادات بنجاح');
                } else {
                  setState(() => isLoading = false);
                  _showErrorSnackbar('فشل في إعادة تعيين الإعدادات');
                }
              } catch (e) {
                setState(() => isLoading = false);
                _showErrorSnackbar('خطأ: $e');
              }
            },
            child: Text('تأكيد'),
          ),
        ],
      ),
    );
  }

  void _showSuccessSnackbar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        backgroundColor: Colors.green,
      ),
    );
  }

  void _showErrorSnackbar(String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(message),
        backgroundColor: Colors.red,
      ),
    );
  }
}
```

## 🎯 الإعدادات المتاحة

| المفتاح | النوع | الوصف | الافتراضي | الحد الأدنى | الحد الأقصى |
|---------|------|-------|----------|-------------|-------------|
| `default_max_downloads` | integer | العدد الافتراضي للتحميلات | 3 | 1 | 100 |
| `max_downloads` | integer | الحد الأقصى للتحميلات | 10 | 1 | 100 |
| `min_downloads` | integer | الحد الأدنى للتحميلات | 1 | 1 | 10 |
| `default_expiry_hours` | integer | مدة انتهاء الصلاحية بالساعات | 24 | 1 | 8760 |
| `max_expiry_hours` | integer | أقصى مدة انتهاء صلاحية | 168 | 1 | 8760 |
| `min_expiry_hours` | integer | أقل مدة انتهاء صلاحية | 1 | 1 | 72 |
| `allow_unlimited` | boolean | السماح بالتحميل غير المحدود | false | - | - |
| `cleanup_expired_after_days` | integer | تنظيف الملفات المنتهية | 30 | 1 | 365 |
| `send_download_email` | boolean | إرسال إيميل التحميل | true | - | - |
| `send_expiry_warning` | boolean | إرسال تحذير انتهاء الصلاحية | true | - | - |
| `warning_hours_before_expiry` | integer | ساعات التحذير | 2 | 1 | 72 |
| `enable_ip_restriction` | boolean | تفعيل قيود IP | false | - | - |
| `enable_user_agent_check` | boolean | تفعيل فحص User Agent | false | - | - |

## 🚀 مميزات النظام

1. **إدارة مرنة**: تحديث جميع الإعدادات من لوحة الإدارة
2. **تطبيق فوري**: التغييرات تطبق مباشرة دون إعادة تشغيل الخادم
3. **حماية**: التحقق من صحة البيانات على مستوى الخادم
4. **سهولة الاستخدام**: واجهة مستخدم بسيطة في Flutter
5. **إعادة التعيين**: إمكانية العودة للإعدادات الافتراضية
6. **نسخ احتياطي**: حفظ جميع التغييرات في قاعدة البيانات

## 🔧 خطوات التنفيذ

1. **تشغيل Migration**: `php artisan migrate`
2. **تهيئة الإعدادات الافتراضية**: تحدث تلقائياً عند أول استخدام
3. **إضافة Authentication**: التأكد من صلاحيات الآدمن
4. **تطبيق Flutter**: استخدام الكود المرفق أعلاه
5. **اختبار النظام**: التأكد من عمل جميع الوظائف

---

## 📞 للاستفسارات

النظام جاهز للاستخدام ويوفر مرونة كاملة في إدارة إعدادات التحميل من لوحة الإدارة في Flutter!
