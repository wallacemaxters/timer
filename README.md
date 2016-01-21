## Table of contents

- [\WallaceMaxters\Timer\DiffInterface (interface)](#interface-wallacemaxterstimerdiffinterface)
- [\WallaceMaxters\Timer\Diff](#class-wallacemaxterstimerdiff)
- [\WallaceMaxters\Timer\Collection](#class-wallacemaxterstimercollection)
- [\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)
- [\WallaceMaxters\Timer\Parser](#class-wallacemaxterstimerparser)

## For Laravel 4 Implementation
- [\WallaceMaxters\Timer\Laravel\TimeFacade](#class-wallacemaxterstimerlaraveltimefacade)
- [\WallaceMaxters\Timer\Laravel\TimeServiceProvider](#class-wallacemaxterstimerlaraveltimeserviceprovider)

<hr /> 
### Interface: \WallaceMaxters\Timer\DiffInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>diff(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> |
| public | <strong>setTime(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>void</em><br /><em>s</em> |

<hr /> 
### Class: \WallaceMaxters\Timer\Diff

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$time=null</strong>)</strong> : <em>void</em> |
| public | <strong>diff(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>WallaceMaxters\Timer\Time new object with seconds of comparision result</em> |
| public | <strong>setTime(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>[\WallaceMaxters\Timer\Diff](#class-wallacemaxterstimerdiff)</em><br /><em>Determine first object of WallaceMaxters\Timer\Time for comparision</em> |

*This class implements [\WallaceMaxters\Timer\DiffInterface](#interface-wallacemaxterstimerdiffinterface)*

<hr /> 
### Class: \WallaceMaxters\Timer\Collection

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array</em> <strong>$times=array()</strong>, <em>string</em> <strong>$format=`'%h:%i:%s'`</strong>)</strong> : <em>void</em> |
| public | <strong>attach(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Attaches a time object to collection</em> |
| public | <strong>average()</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Returns the averaged time of the collection</em> |
| public | <strong>clear()</strong> : <em>\WallaceMaxters\Timer\this</em><br /><em>Gives a empty collection</em> |
| public | <strong>contains(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>boolean</em> |
| public | <strong>count()</strong> : <em>int</em><br /><em>Implementation of Countable. Returns the number of items in collection</em> |
| public static | <strong>create(</strong><em>array</em> <strong>$times=array()</strong>, <em>mixed/string</em> <strong>$format=null</strong>)</strong> : <em>\WallaceMaxters\Timer\static</em><br /><em>Easy way for chainability</em> |
| public | <strong>detach(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Detaches a time of collection</em> |
| public | <strong>each(</strong><em>\callable</em> <strong>$callback</strong>)</strong> : <em>[\WallaceMaxters\Timer\Collection](#class-wallacemaxterstimercollection)</em><br /><em>Walk in all elements of collection</em> |
| public | <strong>exchangeArray(</strong><em>array</em> <strong>$times</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Clear the collection and fill with new itens</em> |
| public | <strong>filter(</strong><em>\callable</em> <strong>$callback</strong>, <em>bool/boolean</em> <strong>$true=true</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Filter all items by callback.</em> |
| public | <strong>first(</strong><em>\callable</em> <strong>$callback=null</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime) / null</em><br /><em>Search time object and return the first</em> |
| public | <strong>getFormat()</strong> : <em>string</em><br /><em>Return the format</em> |
| public | <strong>getIterator()</strong> : <em>\WallaceMaxters\Timer\Wallacemaxters\Timer\Collection</em><br /><em>Get a cloned instance of internal SplObjectStorage</em> |
| public | <strong>isEmpty()</strong> : <em>boolean</em><br /><em>Is empty?</em> |
| public | <strong>jsonSerialize()</strong> : <em>array</em><br /><em>Implementation of \JsonSerializable</em> |
| public | <strong>last(</strong><em>\callable</em> <strong>$callback=null</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime) / null</em><br /><em>Search time object and return the last</em> |
| public | <strong>map(</strong><em>\callable</em> <strong>$callback</strong>)</strong> : <em>mixed</em><br /><em>Map the array to return new value type</em> |
| public | <strong>max()</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Returns the major time</em> |
| public | <strong>merge(</strong><em>[\WallaceMaxters\Timer\Collection](#class-wallacemaxterstimercollection)/\self</em> <strong>$collection</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Merge the collection with another collection</em> |
| public | <strong>mergeArray(</strong><em>array</em> <strong>$times</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Merges the current collection with array</em> |
| public | <strong>min()</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Return the minor time</em> |
| public | <strong>push(</strong><em>int</em> <strong>$seconds</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Add time from seconds in collection</em> |
| public | <strong>reject(</strong><em>\callable</em> <strong>$callback</strong>)</strong> : <em>void</em><br /><em>Filter that returns element when is not rejected by callback</em> |
| public | <strong>setFormat(</strong><em>mixed</em> <strong>$format</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Defines the format used in all items of collection</em> |
| public | <strong>sort(</strong><em>\callable</em> <strong>$callback</strong>)</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Sorts the collection by callback</em> |
| public | <strong>sortAsc()</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Sorts the collection by ascending direction</em> |
| public | <strong>sortDesc()</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Sorts a collection by descending order</em> |
| public | <strong>sum()</strong> : <em>\Wallacemaxters\Timer\Collection</em><br /><em>Create a new instance of WallaceMaxters\Timer\Time with all seconds of items of colection objets summed</em> |
| public | <strong>toArray()</strong> : <em>array</em><br /><em>Converts the collection to array</em> |
| public | <strong>toArrayOfSeconds()</strong> : <em>array</em><br /><em>Converts the collection to array of seconds</em> |

*This class implements \Countable, \IteratorAggregate, \Traversable, \JsonSerializable*

<hr /> 
### Class: \WallaceMaxters\Timer\Time

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$hours</strong>, <em>mixed</em> <strong>$minutes</strong>, <em>mixed</em> <strong>$seconds</strong>)</strong> : <em>void</em> |
| public | <strong>__toString()</strong> : <em>string</em> |
| public | <strong>addHours(</strong><em>int</em> <strong>$hours</strong>)</strong> : <em>void</em><br /><em>Add hours</em> |
| public | <strong>addMinutes(</strong><em>int</em> <strong>$minutes</strong>)</strong> : <em>void</em><br /><em>Add minutes</em> |
| public | <strong>addSeconds(</strong><em>mixed</em> <strong>$seconds</strong>)</strong> : <em>void</em><br /><em>Add seconds</em> |
| public static | <strong>create(</strong><em>int</em> <strong>$hours</strong>, <em>int</em> <strong>$minutes</strong>, <em>int</em> <strong>$seconds</strong>)</strong> : <em>\WallaceMaxters\Timer\static</em><br /><em>Easy way for chainability</em> |
| public static | <strong>createFromCurrentTimestamp()</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Create full hours from current timestamp</em> |
| public static | <strong>createFromFormat(</strong><em>string</em> <strong>$format</strong>, <em>string</em> <strong>$value</strong>, <em>string</em> <strong>$separator=`':'`</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Create time from format</em> |
| public static | <strong>createFromNow(</strong><em>\DateTimeZone</em> <strong>$timezone=null</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Create the time from now time only</em> |
| public static | <strong>createFromString(</strong><em>string</em> <strong>$time</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> |
| public | <strong>diff(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em><br /><em>Get a new instance of WallaceMaxters\Timer\Time of diff with another Time</em> |
| public | <strong>format(</strong><em>mixed/string</em> <strong>$format=null</strong>)</strong> : <em>void</em><br /><em>Format the output time <code> Time::create(1, 59, 59)->format('%h:%i:%s'); // "1:59:59" </code></em> |
| public | <strong>getDiff()</strong> : <em>\WallaceMaxters\Timer\WallaceMaxters\Timer\DiffInterface</em> |
| public | <strong>getSeconds()</strong> : <em>int</em><br /><em>Get seconds from total hours defined</em> |
| public | <strong>isNegative()</strong> : <em>boolean</em> |
| public | <strong>jsonSerialize()</strong> : <em>array</em><br /><em>Implementation for \JsonSerializable</em> |
| public | <strong>setDiff(</strong><em>[\WallaceMaxters\Timer\DiffInterface](#interface-wallacemaxterstimerdiffinterface)</em> <strong>$diff</strong>)</strong> : <em>\WallaceMaxters\Timer\$this</em> |
| public | <strong>setFormat(</strong><em>string</em> <strong>$format</strong>)</strong> : <em>void</em><br /><em>Define the format used in self::__toString</em> |
| public | <strong>setHours(</strong><em>int</em> <strong>$hours</strong>)</strong> : <em>void</em> |
| public | <strong>setMinutes(</strong><em>\WallaceMaxters\Timer\minutes</em> <strong>$minutes</strong>)</strong> : <em>void</em> |
| public | <strong>setSeconds(</strong><em>int</em> <strong>$seconds</strong>)</strong> : <em>void</em> |
| public | <strong>setTime(</strong><em>int</em> <strong>$hours</strong>, <em>int</em> <strong>$minutes</strong>, <em>int</em> <strong>$seconds</strong>)</strong> : <em>\WallaceMaxters\Timer\$this</em> |

*This class implements \JsonSerializable*

<hr /> 
### Class: \WallaceMaxters\Timer\Parser

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> <strong>$time=null</strong>)</strong> : <em>void</em><br /><em>Object Constructor</em> |
| public | <strong>fromFormat(</strong><em>string</em> <strong>$format</strong>, <em>string</em> <strong>$value</strong>, <em>string</em> <strong>$separator=`':'`</strong>)</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> |
| public | <strong>getTime()</strong> : <em>[\WallaceMaxters\Timer\Time](#class-wallacemaxterstimertime)</em> |
| public | <strike><strong>parseFormat(</strong><em>mixed</em> <strong>$format</strong>, <em>mixed</em> <strong>$value</strong>, <em>string</em> <strong>$separator=`':'`</strong>)</strong> : <em>void</em></strike><br /><em>DEPRECATED - use format instead of</em> |

<hr /> 
### Class: \WallaceMaxters\Timer\Laravel\TimeFacade

| Visibility | Function |
|:-----------|:---------|
| protected static | <strong>getFacadeAccessor()</strong> : <em>mixed</em> |

*This class extends \Illuminate\Support\Facades\Facade*

<hr /> 
### Class: \WallaceMaxters\Timer\Laravel\TimeServiceProvider

| Visibility | Function |
|:-----------|:---------|
| public | <strong>register()</strong> : <em>void</em> |

*This class extends \Illuminate\Support\ServiceProvider*

