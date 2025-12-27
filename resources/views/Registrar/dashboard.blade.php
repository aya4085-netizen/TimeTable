@extends('layout.app')

@section('title','لوحة شؤون الطلبة')

@section('content')

<h1 class="main-title">لوحة تحكم شؤون الطلبة</h1>

<div class="row g-3">

    {{-- الطلبة --}}
    <div class="col-12 col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-mortarboard-fill fs-1" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold fs-4">{{ $studentsCount }}</div>
                    <div class="text-muted">إجمالي الطلبة</div>
                </div>
            </div>
        </div>
    </div>

   
            </div>
        </div>
    </div>
    

               
            </div>
        </div>
    </div>

</div>

@endsection
