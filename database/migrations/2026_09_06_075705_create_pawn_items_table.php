use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pawn_items', function (Blueprint $table) {
            $table->id();
            
            // ភ្ជាប់ទំនាក់ទំនងទៅកាន់ id នៃតារាង customers
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            
            $table->string('category', 100);
            $table->string('item_name', 255);
            $table->string('imei_serial_tag', 100)->nullable();
            $table->string('storage_location', 255)->nullable();
            $table->text('included_accessories')->nullable();
            $table->decimal('estimated_market_value', 12, 2);
            $table->decimal('approved_loan', 12, 2);
            $table->decimal('monthly_interest_rate', 5, 2);
            $table->date('pawn_date');
            $table->date('maturity_due_date')->nullable();
            $table->string('item_photo', 255)->nullable();
            $table->text('item_condition_details')->nullable();
            $table->string('item_status', 50)->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pawn_items');
    }
};
