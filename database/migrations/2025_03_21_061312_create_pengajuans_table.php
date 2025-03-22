    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('pengajuans', function (Blueprint $table) {
                $table->id();
                $table->string('kode_pengajuan', 12)->unique();
                $table->unsignedBigInteger('member_id');
                $table->string('nama_barang', 255);
                $table->date('tgl_pengajuan');
                $table->integer('qty');
                $table->boolean('terpenuhi')->default('0');
                $table->timestamps();

                $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pengajuans');
        }
    };
