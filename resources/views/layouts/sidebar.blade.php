  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ setActive('home') }}">
          <a href="{{ route('home') }}" >
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>
        
        @if (Auth::user()->level == 1)
        <li class="{{ setActive('kategori.index') }}">
          <a href="{{ route('kategori.index') }}" >
            <i class="fa fa-cube"></i>
            <span>Kategori</span>
          </a>
        </li>
        <li class="{{ setActive('produk.index') }}">
          <a href="{{ route('produk.index') }}" >
            <i class="fa fa-cubes"></i>
            <span>Produk</span>
          </a>
        </li>
        <li class="{{ setActive('member.index') }}">
          <a href="{{ route('member.index') }}" >
            <i class="fa fa-credit-card"></i>
            <span>Member</span>
          </a>
        </li>
        <li class="{{ setActive('supplier.index') }}">
          <a href="{{ route('supplier.index') }}" >
            <i class="fa fa-truck"></i>
            <span>Supplier</span>
          </a>
        </li>
        <li class="{{ setActive('pengeluaran.index') }}">
          <a href="{{ route('pengeluaran.index') }}" >
            <i class="fa fa-money"></i>
            <span>Pengeluaran</span>
          </a>
        </li>
        <li class="{{ setActive(['user.index', 'user.profil']) }}">
          <a href="{{ route('user.index') }}" >
            <i class="fa fa-user"></i>
            <span>User</span>
          </a>
        </li>
        <li class="{{ setActive(['penjualan.index', 'penjualan_detail.index']) }}">
          <a href="{{ route('penjualan.index') }}" >
            <i class="fa fa-upload"></i>
            <span>Penjualan</span>
          </a>
        </li>
        <li class="{{ setActive(['pembelian.index', 'pembelian_detail.index']) }}">
          <a href="{{ route('pembelian.index') }}" >
            <i class="fa fa-download"></i>
            <span>Pembelian</span>
          </a>
        </li>
        <li class="{{ setActive(['laporan.index', 'laporan.refresh']) }}">
          <a href="{{ route('laporan.index') }}" >
            <i class="fa fa-file-pdf-o"></i>
            <span>Laporan</span>
          </a>
        </li>
        <li class="{{ setActive('setting.index') }}">
          <a href="{{ route('setting.index') }}" >
            <i class="fa fa-gears"></i>
            <span>Setting</span>
          </a>
        </li>
        
        @else
        <li class="{{ setActive('transaksi.index') }}">
          <a href="{{ route('transaksi.index') }}" >
            <i class="fa fa-shopping-cart"></i>
            <span>Transaksi</span>
          </a>
        </li>
        <li class="{{ setActive('pengeluaran.new') }}">
          <a href="{{ route('transaksi.new') }}" >
            <i class="fa fa-cart-plus"></i>
            <span>Transaksi Baru</span>
          </a>
        </li>
        @endif
      </ul>
    </section>
  </aside>