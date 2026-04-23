<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .border { border: 1px solid #000000; }
        .bg-header { background-color: #e2e8f0; font-weight: bold; text-align: center; }
        .bg-total { background-color: #1e293b; color: #ffffff; font-weight: bold; }
        .text-center { text-align: center; }
        .text-hold { color: #b45309; font-size: 9px; } /* Warna coklat/amber untuk Hold */
        .text-rework { color: #be123c; font-size: 9px; } /* Warna merah untuk Rework */
        .text-muted { color: #94a3b8; }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th class="border bg-header">Category</th>
                <th class="border bg-header">Variant</th>
                @foreach($months as $m) <th class="border bg-header">{{ $m }}</th> @endforeach
                <th class="border bg-header">Release Rate Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                @php
                    $variants = $category->variants;
                    $variantCount = $variants->count();
                    $catTotalBatch = array_fill(1, 12, 0);
                    $catTotalHold = array_fill(1, 12, 0);
                    $catTotalRework = array_fill(1, 12, 0);
                    $rowSpanValue = $variantCount > 0 ? $variantCount + 1 : 1;
                @endphp

                @foreach ($variants as $index => $variant)
                    <tr>
                        @if ($index === 0)
                            <td class="border text-center" rowspan="{{ $rowSpanValue }}" style="vertical-align: middle;">
                                {{ $category->name }}
                            </td>
                        @endif
                        <td class="border" style="font-style: italic;">{{ $variant->name }}</td>
                        
                        @php $vTotal = 0; $vIssue = 0; @endphp
                        
                        @foreach (range(1, 12) as $m)
                            @php
                                $t = $variant->{"month_{$m}_count"} ?? 0;
                                $h = $variant->{"month_{$m}_hold"} ?? 0;
                                $r = $variant->{"month_{$m}_rework"} ?? 0;
                                
                                $vTotal += $t; 
                                $vIssue += ($h + $r);

                                $catTotalBatch[$m] += $t; 
                                $catTotalHold[$m] += $h; 
                                $catTotalRework[$m] += $r;
                            @endphp
                            <td class="border text-center">
                                @if($t > 0)
                                    <b>{{ $t }}</b>
                                    @if($h > 0 || $r > 0)
                                        <br>
                                        <small>
                                            @if($h > 0) <span class="text-hold">H:{{ $h }}</span> @endif
                                            @if($r > 0) <span class="text-rework">R:{{ $r }}</span> @endif
                                        </small>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        @endforeach

                        @php
                            $released = $vTotal - $vIssue;
                            $perc = $vTotal > 0 ? ($released / $vTotal) * 100 : 0;
                        @endphp
                        <td class="border text-center" style="font-weight: bold;">
                            {{ number_format($perc, 1) }}%
                            <br><small>({{ $released }}/{{ $vTotal }})</small>
                        </td>
                    </tr>
                @endforeach

                {{-- Baris TOTAL Kategori --}}
                <tr>
                    @if ($variantCount === 0)
                        <td class="border text-center">{{ $category->name }}</td>
                    @endif
                    <td class="border bg-total">TOTAL {{ $category->name }}</td>
                    
                    @php $ctTotal = 0; $ctIssue = 0; @endphp
                    
                    @foreach (range(1, 12) as $m)
                        @php
                            $ctTotal += $catTotalBatch[$m];
                            $ctIssue += ($catTotalHold[$m] + $catTotalRework[$m]);
                        @endphp
                        <td class="border bg-total text-center">
                            {{ $catTotalBatch[$m] }}
                            @if($catTotalHold[$m] > 0 || $catTotalRework[$m] > 0)
                                <br>
                                <small style="font-size: 8px;">
                                    @if($catTotalHold[$m] > 0) H:{{ $catTotalHold[$m] }} @endif
                                    @if($catTotalRework[$m] > 0) R:{{ $catTotalRework[$m] }} @endif
                                </small>
                            @endif
                        </td>
                    @endforeach

                    @php
                        $cRel = $ctTotal - $ctIssue;
                        $cPerc = $ctTotal > 0 ? ($cRel / $ctTotal) * 100 : 0;
                    @endphp
                    <td class="border bg-total text-center" style="background-color: #0f172a;">
                        {{ number_format($cPerc, 1) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>